<?php

namespace Tests\Feature;

use App\Models\Librarian;
use App\Models\Member;
use App\Models\MemberAuth;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Hash;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use Tests\TestCase;

class RouteIntegrityTest extends TestCase
{
    use RefreshDatabase;

    public function test_static_named_route_references_are_registered(): void
    {
        $registered = array_keys(app('router')->getRoutes()->getRoutesByName());
        $missing = [];

        foreach ($this->applicationPhpFiles() as $file) {
            $contents = file_get_contents($file);

            if ($contents === false) {
                continue;
            }

            preg_match_all(
                '/\b(?:route|to_route)\s*\(\s*[\'\"]([^\'\"]+)[\'\"]/',
                $contents,
                $matches
            );

            foreach (array_unique($matches[1]) as $routeName) {
                if (! in_array($routeName, $registered, true)) {
                    $missing[] = $routeName.' in '.$this->relativePath($file);
                }
            }
        }

        sort($missing);

        $this->assertSame([], $missing, 'Static route references must point to registered named routes.');
    }

    public function test_parameterless_web_get_routes_do_not_return_server_errors_for_guests(): void
    {
        $routes = collect(app('router')->getRoutes()->getRoutes())
            ->filter(fn (Route $route): bool => in_array('GET', $route->methods(), true))
            ->filter(fn (Route $route): bool => in_array('web', $route->gatherMiddleware(), true))
            ->filter(fn (Route $route): bool => ! str_contains($route->uri(), '{'))
            ->reject(fn (Route $route): bool => str_starts_with($route->uri(), 'telescope'));

        foreach ($routes as $route) {
            $response = $this->get('/'.ltrim($route->uri(), '/'));

            $this->assertLessThan(
                500,
                $response->getStatusCode(),
                sprintf('GET /%s returned a server error.', $route->uri())
            );
        }
    }

    public function test_parameterless_portal_routes_render_for_their_authenticated_roles(): void
    {
        $librarian = Librarian::factory()->create();
        $administrator = MemberAuth::factory()->create([
            'librarian_id' => $librarian->librarian_id,
            'username' => 'route_audit_admin',
            'password_hash' => Hash::make('password123'),
            'account_type' => 'Administrator',
            'account_status' => 'Active',
        ]);

        $this->actingAs($administrator, 'member');
        $this->assertPortalRoutesDoNotFail(['admin/', 'librarian/']);

        $staffProfile = Librarian::factory()->create();
        $staffAccount = MemberAuth::factory()->create([
            'librarian_id' => $staffProfile->librarian_id,
            'username' => 'route_audit_librarian',
            'password_hash' => Hash::make('password123'),
            'account_type' => 'Librarian',
            'account_status' => 'Active',
        ]);

        $this->actingAs($staffAccount, 'member');
        $this->assertPortalRoutesDoNotFail(['admin/', 'librarian/']);

        $member = Member::factory()->create();
        $student = MemberAuth::factory()->create([
            'member_id' => $member->member_id,
            'username' => 'route_audit_student',
            'password_hash' => Hash::make('password123'),
            'account_type' => 'Member',
            'account_status' => 'Active',
        ]);

        $this->actingAs($student, 'member');
        $this->assertPortalRoutesDoNotFail(['student/']);
    }

    /** @return list<string> */
    private function applicationPhpFiles(): array
    {
        $files = [base_path('bootstrap/app.php')];

        foreach ([app_path('Http/Controllers'), resource_path('views')] as $directory) {
            $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory));

            foreach ($iterator as $file) {
                if ($file->isFile() && $file->getExtension() === 'php') {
                    $files[] = $file->getPathname();
                }
            }
        }

        return $files;
    }

    private function relativePath(string $file): string
    {
        return str_replace('\\', '/', str_replace(base_path().DIRECTORY_SEPARATOR, '', $file));
    }

    /** @param list<string> $prefixes */
    private function assertPortalRoutesDoNotFail(array $prefixes): void
    {
        $routes = collect(app('router')->getRoutes()->getRoutes())
            ->filter(fn (Route $route): bool => in_array('GET', $route->methods(), true))
            ->filter(fn (Route $route): bool => ! str_contains($route->uri(), '{'))
            ->filter(fn (Route $route): bool => collect($prefixes)->contains(
                fn (string $prefix): bool => str_starts_with($route->uri(), $prefix)
            ));

        foreach ($routes as $route) {
            $response = $this->get('/'.$route->uri());

            $this->assertLessThan(
                500,
                $response->getStatusCode(),
                sprintf('GET /%s returned a server error for an authenticated portal user.', $route->uri())
            );
        }
    }
}
