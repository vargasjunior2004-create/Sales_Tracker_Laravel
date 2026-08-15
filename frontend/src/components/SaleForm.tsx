import { useState, useEffect, useRef } from 'react';
import api from '../services/api';
import { Button, Input, Select, Card, Alert, TotalDisplay } from './ui';
import type { Plan, Customer, SaleFormData } from '../types';

const REQUEST_TYPES = [
  { value: 'nuevo_contrato', label: 'Nuevo Contrato' },
  { value: 'cambio_plan', label: 'Cambio de Plan' },
  { value: 'recontratacion', label: 'Recontratacion' },
  { value: 'retiro', label: 'Retiro' },
  { value: 'adicion', label: 'Adicion' },
  { value: 'baja_temporal', label: 'Baja Temporal' },
  { value: 'otro', label: 'Otro' },
];

const CHANGE_REASONS = [
  'ECONÓMICOS', 'MEJOR CALIDAD', 'POCO USO', 'AUMENTO DE DISPOSITIVOS',
  'VIAJE', 'NO UTILIZA EL SERVICIO', 'OTROS',
];

interface SaleFormState {
  date: string;
  clientCode: string;
  clientName: string;
  serviceType: 'internet' | 'tv' | 'combo';
  requestType: string;
  changeReason: string;
  notes: string;
  planId: string;
}

export default function SaleForm() {
  const today = new Date().toISOString().split('T')[0];
  const [plans, setPlans] = useState<Plan[]>([]);
  const [form, setForm] = useState<SaleFormState>({
    date: today, clientCode: '', clientName: '', serviceType: 'internet',
    requestType: 'nuevo_contrato', changeReason: '', notes: '', planId: '',
  });
  const [selectedPlan, setSelectedPlan] = useState<Plan | null>(null);
  const [error, setError] = useState('');
  const [success, setSuccess] = useState('');
  const [loading, setLoading] = useState(false);

  const [query, setQuery] = useState('');
  const [customers, setCustomers] = useState<Customer[]>([]);
  const [showDropdown, setShowDropdown] = useState(false);
  const [selectedCustomer, setSelectedCustomer] = useState<Customer | null>(null);
  const dropdownRef = useRef<HTMLDivElement>(null);

  useEffect(() => {
    api.getActivePlans().then(setPlans).catch(() => {});
  }, []);

  const searchCustomers = async (q: string) => {
    setQuery(q);
    if (!q.trim()) { setCustomers([]); return; }
    try {
      const res = await api.searchCustomers(q);
      setCustomers(res);
      setShowDropdown(true);
    } catch { setCustomers([]); }
  };

  const pickCustomer = (c: Customer) => {
    setSelectedCustomer(c);
    setForm((prev) => ({ ...prev, clientCode: c.code, clientName: c.name }));
    setQuery(c.name);
    setCustomers([]);
    setShowDropdown(false);
  };

  useEffect(() => {
    const onClick = (e: MouseEvent) => {
      if (dropdownRef.current && !dropdownRef.current.contains(e.target as Node)) setShowDropdown(false);
    };
    document.addEventListener('click', onClick);
    return () => document.removeEventListener('click', onClick);
  }, []);

  const filteredPlans = plans.filter((p) => p.type === form.serviceType);
  const currentPlans = filteredPlans.filter((p) => !p.legacy);
  const legacyPlans = filteredPlans.filter((p) => p.legacy);
  const isRetiro = form.requestType === 'retiro';

  useEffect(() => {
    if (form.planId) {
      const p = plans.find((pl) => String(pl.id) === String(form.planId));
      setSelectedPlan(p || null);
    } else {
      setSelectedPlan(null);
    }
  }, [form.planId, plans]);

  const handleChange = (e: React.ChangeEvent<HTMLInputElement | HTMLSelectElement>) => {
    const { name, value } = e.target;
    setForm((prev) => {
      const next = { ...prev, [name]: value };
      if (name === 'serviceType' || name === 'requestType') next.planId = '';
      return next;
    });
  };

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    setError('');
    setSuccess('');
    setLoading(true);
    try {
      const payload: SaleFormData = {
        date: form.date,
        clientCode: form.clientCode,
        clientName: form.clientName,
        serviceType: form.serviceType,
        requestType: form.requestType,
        changeReason: form.requestType === 'cambio_plan' ? form.changeReason : '',
        notes: form.notes,
        planId: Number(form.planId),
      };
      await api.createSale(payload);
      setSuccess('Venta registrada correctamente');
      setForm({ date: today, clientCode: '', clientName: '', serviceType: 'internet', requestType: 'nuevo_contrato', changeReason: '', notes: '', planId: '' });
      setSelectedPlan(null); setSelectedCustomer(null); setQuery(''); setCustomers([]);
    } catch (err) {
      setError((err as { error?: string }).error || 'Error al registrar venta');
    } finally {
      setLoading(false);
    }
  };

  return (
    <div className="space-y-4">
      <h1 className="text-2xl font-bold text-slate-900">Nuevo Movimiento</h1>

      <Card className="p-5">
        <form onSubmit={handleSubmit} className="space-y-4">
          {error && <Alert type="error">{error}</Alert>}
          {success && <Alert type="success">{success}</Alert>}

          <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <Input label="Fecha" type="date" name="date" value={form.date} onChange={handleChange} required />
            <Select label="Tipo de Solicitud" name="requestType" value={form.requestType} onChange={handleChange} required>
              {REQUEST_TYPES.map((t) => (
                <option key={t.value} value={t.value}>{t.label}</option>
              ))}
            </Select>
          </div>

          <div ref={dropdownRef} className="relative">
            <Input
              label="Cliente (kardex o nombre)"
              value={query}
              onChange={(e) => { setSelectedCustomer(null); searchCustomers(e.target.value); }}
              placeholder="Escriba kardex o nombre del cliente..."
              autoComplete="off"
            />
            {showDropdown && customers.length > 0 && (
              <ul className="absolute z-20 mt-1 w-full bg-white border border-slate-200 rounded-xl shadow-lg max-h-56 overflow-auto">
                {customers.map((c) => (
                  <li key={c.id}>
                    <button type="button" onClick={() => pickCustomer(c)}
                      className="w-full text-left px-4 py-2 hover:bg-green-50 flex items-center justify-between gap-2">
                      <span className="text-sm text-slate-700">{c.name}</span>
                      <span className="text-xs font-mono text-slate-400">{c.code}</span>
                    </button>
                  </li>
                ))}
              </ul>
            )}
            {!query && !selectedCustomer && (
              <p className="text-xs text-slate-400 mt-1">Ingrese kardex o nombre; si no existe, se creará automáticamente.</p>
            )}
          </div>

          <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <Input label="Codigo Cliente" name="clientCode" value={form.clientCode} onChange={handleChange} required placeholder="Ej: 13316" />
            <Input label="Nombre Completo" name="clientName" value={form.clientName} onChange={handleChange} required placeholder="Nombre del cliente" />
          </div>

          <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <Select label="Tipo de Servicio" name="serviceType" value={form.serviceType} onChange={handleChange}>
              <option value="internet">Solo Internet</option>
              <option value="tv">Solo TV Cable</option>
              <option value="combo">Combo Internet + TV</option>
            </Select>
            <Select label="Plan" name="planId" value={form.planId} onChange={handleChange} required>
              <option value="">Seleccionar plan...</option>
              <optgroup label="Planes vigentes">
                {currentPlans.map((p) => (
                  <option key={p.id} value={p.id}>{p.label} - {parseFloat(p.monthly).toFixed(0)} Bs</option>
                ))}
              </optgroup>
              {isRetiro && legacyPlans.length > 0 && (
                <optgroup label="Planes anteriores">
                  {legacyPlans.map((p) => (
                    <option key={p.id} value={p.id}>{p.label} - {parseFloat(p.monthly).toFixed(0)} Bs</option>
                  ))}
                </optgroup>
              )}
            </Select>
          </div>

          {form.requestType === 'cambio_plan' && (
            <Select label="Motivo de Cambio" name="changeReason" value={form.changeReason} onChange={handleChange} required>
              <option value="">Seleccionar motivo...</option>
              {CHANGE_REASONS.map((r) => <option key={r} value={r}>{r}</option>)}
            </Select>
          )}

          <Input label="Comentarios (opcional)" name="notes" value={form.notes} onChange={handleChange} placeholder="Notas internas" />

          {selectedPlan && (
            <div className="bg-green-50 border border-green-200 rounded-xl p-4 space-y-1">
              <div className="flex justify-between text-sm">
                <span className="text-slate-500">Plan</span>
                <span className="font-medium text-slate-700">{selectedPlan.label}</span>
              </div>
              <TotalDisplay value={selectedPlan.monthly} label="Total a cobrar (Bs/mes)" />
            </div>
          )}

          <Button type="submit" size="lg" className="w-full" disabled={loading || !form.planId}>
            {loading ? 'Registrando...' : 'Registrar Movimiento'}
          </Button>
        </form>
      </Card>
    </div>
  );
}
