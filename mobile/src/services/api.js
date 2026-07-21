export function getDefaultServerUrl() {
  const host = window.location.hostname || '127.0.0.1';
  const port = window.location.port ? `:${window.location.port}` : '';
  if (host === 'localhost' || host === '127.0.0.1') {
    return 'http://127.0.0.1:8000';
  }
  return `${window.location.protocol}//${host}${port}`;
}

export function getServerUrl() {
  return localStorage.getItem('server_url') || getDefaultServerUrl();
}

export function setServerUrl(url) {
  let cleaned = (url || '').trim();
  if (cleaned && !cleaned.startsWith('http://') && !cleaned.startsWith('https://')) {
    cleaned = `http://${cleaned}`;
  }
  cleaned = cleaned.replace(/\/+$/, '');
  localStorage.setItem('server_url', cleaned);
  return cleaned;
}

export async function fetchApi(endpoint, options = {}) {
  const baseUrl = getServerUrl();
  const cleanEndpoint = endpoint.startsWith('/') ? endpoint : `/${endpoint}`;
  const fullUrl = `${baseUrl}${cleanEndpoint}`;

  const defaultHeaders = {
    'Accept': 'application/json',
    'X-Requested-With': 'XMLHttpRequest',
  };

  const response = await fetch(fullUrl, {
    ...options,
    headers: {
      ...defaultHeaders,
      ...(options.headers || {}),
    },
  });

  return response;
}
