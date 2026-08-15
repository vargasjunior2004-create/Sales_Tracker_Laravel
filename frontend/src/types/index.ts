export interface User {
  id: number;
  name: string;
  email: string;
  role: 'admin' | 'ventas';
  active: boolean;
  created_at?: string;
}

export interface Plan {
  id: number;
  code: string;
  label: string;
  type: 'internet' | 'tv' | 'combo';
  speed: number | null;
  monthly: string;
  installation: string;
  total: string;
  active: boolean;
  legacy: boolean;
  created_at?: string;
}

export interface Sale {
  id: number;
  date: string;
  clientCode: string;
  clientName: string;
  customer_id: number | null;
  serviceType: 'internet' | 'tv' | 'combo';
  requestType: string;
  changeReason: string;
  planFrom: string;
  totalFrom: number | null;
  notes: string;
  total: string;
  plan_id: number;
  createdBy_id: number;
  lastEditedBy_id: number | null;
  lastEditedAt: string | null;
  created_at: string | null;
  plan?: Plan;
  createdBy?: User;
  lastEditedBy?: User;
}

export interface Customer {
  id: number;
  code: string;
  name: string;
  active: boolean;
  created_at?: string;
}

export interface CashCount {
  id: number;
  date: string;
  coin_050: number;
  coin_1: number;
  coin_2: number;
  coin_5: number;
  bill_10: number;
  bill_20: number;
  bill_50: number;
  bill_100: number;
  bill_200: number;
  total: number;
  createdBy_id: number;
  createdBy?: User;
}

export interface Outflow {
  id: number;
  date: string;
  personName: string;
  amount: string;
  concept: string;
  createdBy_id: number;
  created_at: string | null;
  createdBy?: User;
}

export interface CashCountResponse {
  cashCount: CashCount | null;
  outflows: Outflow[];
  totalOutflows: number;
}

export interface LoginResponse {
  token: string;
  user: User;
}

export interface MeResponse {
  user: User;
}

export interface OutflowCreateResponse {
  outflow: Outflow;
  totalOutflows: number;
}

export interface OutflowDeleteResponse {
  totalOutflows: number;
}

export interface ReportLinkResponse {
  url: string;
  token: string;
}

export interface PlanFormData {
  code: string;
  label: string;
  type: 'internet' | 'tv' | 'combo';
  speed: number | null;
  monthly: number;
  installation: number;
}

export interface UserFormData {
  name: string;
  email: string;
  password?: string;
  role: 'admin' | 'ventas';
  active?: boolean;
}

export interface SaleFormData {
  date: string;
  clientCode: string;
  clientName: string;
  serviceType: 'internet' | 'tv' | 'combo';
  requestType: string;
  changeReason?: string;
  notes?: string;
  planId: number;
}
