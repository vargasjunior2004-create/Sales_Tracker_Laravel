import type {
  LoginResponse,
  MeResponse,
  Plan,
  Sale,
  User,
  Customer,
  CashCountResponse,
  CashCount,
  OutflowCreateResponse,
  OutflowDeleteResponse,
  PlanFormData,
  UserFormData,
  SaleFormData,
} from '../types';

const API_URL = '';

async function request<T>(path: string, options: RequestInit = {}): Promise<T> {
  const token = localStorage.getItem('token');
  const headers: Record<string, string> = {
    'Content-Type': 'application/json',
    ...(options.headers as Record<string, string>),
  };
  if (token) headers['Authorization'] = `Bearer ${token}`;

  const res = await fetch(`${API_URL}${path}`, { ...options, headers });

  if (!res.ok) {
    const err = await res.json().catch(() => ({ error: 'Error del servidor' }));
    throw err;
  }

  const ct = res.headers.get('content-type');
  if (ct && (ct.includes('application/pdf') || ct.includes('spreadsheetml') || ct.includes('octet-stream'))) {
    return res.blob() as Promise<T>;
  }

  return res.json();
}

const api = {
  login: (email: string, password: string) =>
    request<LoginResponse>('/api/auth/login', { method: 'POST', body: JSON.stringify({ email, password }) }),

  me: () => request<MeResponse>('/api/auth/me'),

  getPlans: () => request<Plan[]>('/api/plans'),
  getActivePlans: () => request<Plan[]>('/api/plans/active'),
  createPlan: (data: PlanFormData) => request<Plan>('/api/plans', { method: 'POST', body: JSON.stringify(data) }),
  updatePlan: (id: number, data: Partial<PlanFormData & { active: boolean }>) =>
    request<Plan>(`/api/plans/${id}`, { method: 'PUT', body: JSON.stringify(data) }),

  getSales: (from?: string, to?: string, requestType?: string) => {
    const params = new URLSearchParams();
    if (from) params.set('from', from);
    if (to) params.set('to', to);
    if (requestType) params.set('requestType', requestType);
    const qs = params.toString();
    return request<Sale[]>(`/api/sales${qs ? '?' + qs : ''}`);
  },
  createSale: (data: SaleFormData) => request<Sale>('/api/sales', { method: 'POST', body: JSON.stringify(data) }),
  updateSale: (id: number, data: Partial<SaleFormData>) =>
    request<Sale>(`/api/sales/${id}`, { method: 'PUT', body: JSON.stringify(data) }),

  getUsers: () => request<User[]>('/api/users'),
  createUser: (data: UserFormData) => request<User>('/api/users', { method: 'POST', body: JSON.stringify(data) }),
  updateUser: (id: number, data: Partial<UserFormData>) =>
    request<User>(`/api/users/${id}`, { method: 'PUT', body: JSON.stringify(data) }),

  searchCustomers: (q: string) => {
    const params = new URLSearchParams();
    if (q) params.set('q', q);
    return request<Customer[]>(`/api/customers?${params.toString()}`);
  },

  getCashCount: (date?: string) => {
    const params = date ? `?date=${date}` : '';
    return request<CashCountResponse>(`/api/cash-count${params}`);
  },
  saveCashCount: (data: { date: string } & Record<string, number>) =>
    request<CashCount>('/api/cash-count', { method: 'POST', body: JSON.stringify(data) }),
  addOutflow: (data: { date: string; personName: string; amount: number; concept?: string }) =>
    request<OutflowCreateResponse>('/api/cash-count/outflows', { method: 'POST', body: JSON.stringify(data) }),
  deleteOutflow: (id: number) =>
    request<OutflowDeleteResponse>(`/api/cash-count/outflows/${id}`, { method: 'DELETE' }),

  getPDF: (from?: string, to?: string) => {
    const params = new URLSearchParams();
    if (from) params.set('from', from);
    if (to) params.set('to', to);
    return request<Blob>(`/api/reports/pdf?${params.toString()}`);
  },
  getXLSX: (from?: string, to?: string) => {
    const params = new URLSearchParams();
    if (from) params.set('from', from);
    if (to) params.set('to', to);
    return request<Blob>(`/api/reports/xlsx?${params.toString()}`);
  },
  getCashPDF: (date?: string) => {
    const params = date ? `?date=${date}` : '';
    return request<Blob>(`/api/cash-count/pdf${params}`);
  },
};

export default api;
