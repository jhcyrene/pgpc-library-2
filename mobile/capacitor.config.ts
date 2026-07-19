import type { CapacitorConfig } from '@capacitor/cli';

const config: CapacitorConfig = {
  appId: 'com.pgpc.library',
  appName: 'PGPC Library App',
  webDir: 'dist',

  server: {
    url: 'http://192.168.1.35:8000', // Change 192.168.80.1 / 192.168.1.35 to your current Wi-Fi IP
    cleartext: true,
  }
};


export default config;
