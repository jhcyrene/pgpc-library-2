import type { CapacitorConfig } from '@capacitor/cli';

const config: CapacitorConfig = {
  appId: 'com.pgpc.library',
  appName: 'PGPC Library App',
  webDir: 'dist',
  server: {
    // Set your server URL here, or use the in-app URL input to change it.
    // url: 'http://192.168.1.40:8000',

    cleartext: true,  // Allow HTTP (non-HTTPS) traffic
    allowNavigation: [
      '*',
      'http://*',
      'https://*',
      '*.trycloudflare.com'
    ]
  }
};

export default config;
