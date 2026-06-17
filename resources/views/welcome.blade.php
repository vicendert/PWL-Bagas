<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="SportSpace — Platform manajemen sewa lapangan olahraga terpadu. Kelola reservasi, fasilitas, dan kualitas lapangan dengan mudah.">
<title>SportSpace — Platform Manajemen Lapangan Olahraga</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr@4.6.13/dist/flatpickr.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr@4.6.13/dist/flatpickr.min.css">
<script src="https://cdn.quilljs.com/1.3.7/quill.min.js"></script>
<link rel="stylesheet" href="https://cdn.quilljs.com/1.3.7/quill.snow.css">
<style>
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
:root {
  --primary: #6366f1;
  --primary-dark: #4f46e5;
  --primary-light: #818cf8;
  --accent: #06b6d4;
  --success: #10b981;
  --warning: #f59e0b;
  --danger: #ef4444;
  --sidebar-w: 260px;
  --sidebar-bg: #0f172a;
  --topbar-h: 64px;
  --bg: #f1f5f9;
  --card: #ffffff;
  --border: #e2e8f0;
  --text: #1e293b;
  --text-muted: #64748b;
  --radius: 12px;
  --shadow: 0 1px 3px rgba(0,0,0,.06), 0 4px 16px rgba(0,0,0,.04);
  --shadow-lg: 0 8px 30px rgba(0,0,0,.10);
}
html, body { height: 100%; font-family: 'Inter', sans-serif; background: var(--bg); color: var(--text); }

/* ── Scrollbar ── */
::-webkit-scrollbar { width: 6px; height: 6px; }
::-webkit-scrollbar-track { background: transparent; }
::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }

/* ── Login ── */
.login-wrap {
  min-height: 100vh; display: flex; align-items: center; justify-content: center;
  background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 50%, #0f172a 100%);
  position: relative; overflow: hidden;
}
.login-bg-orb {
  position: absolute; border-radius: 50%; filter: blur(80px); opacity: .35;
}
.login-card {
  position: relative; z-index: 2; width: 100%; max-width: 440px;
  background: rgba(255,255,255,.05); backdrop-filter: blur(24px);
  border: 1px solid rgba(255,255,255,.12); border-radius: 24px;
  padding: 48px 40px; box-shadow: 0 32px 64px rgba(0,0,0,.4);
}
.login-logo { text-align: center; margin-bottom: 32px; }
.login-logo-icon {
  width: 64px; height: 64px; border-radius: 20px; margin: 0 auto 16px;
  background: linear-gradient(135deg, var(--primary), var(--accent));
  display: flex; align-items: center; justify-content: center;
  box-shadow: 0 8px 24px rgba(99,102,241,.4);
}
.login-title { font-size: 28px; font-weight: 800; color: #fff; margin-bottom: 4px; }
.login-sub { color: rgba(255,255,255,.55); font-size: 14px; }
.form-field { margin-bottom: 20px; }
.form-label { display: block; font-size: 12px; font-weight: 600; color: rgba(255,255,255,.7); letter-spacing: .5px; text-transform: uppercase; margin-bottom: 8px; }
.form-input {
  width: 100%; padding: 13px 16px; font-size: 15px; color: #fff;
  background: rgba(255,255,255,.08); border: 1px solid rgba(255,255,255,.15);
  border-radius: 10px; outline: none; transition: all .2s;
  font-family: inherit;
}
.form-input:focus { border-color: var(--primary-light); background: rgba(99,102,241,.15); box-shadow: 0 0 0 3px rgba(99,102,241,.2); }
.form-input::placeholder { color: rgba(255,255,255,.3); }
.btn-login {
  width: 100%; padding: 14px; font-size: 16px; font-weight: 700;
  background: linear-gradient(135deg, var(--primary), var(--primary-dark));
  color: #fff; border: none; border-radius: 10px; cursor: pointer;
  transition: all .2s; letter-spacing: .3px; margin-top: 8px;
}
.btn-login:hover { transform: translateY(-1px); box-shadow: 0 8px 24px rgba(99,102,241,.5); }
.btn-login:active { transform: translateY(0); }
.login-error {
  background: rgba(239,68,68,.15); border: 1px solid rgba(239,68,68,.3);
  color: #fca5a5; border-radius: 8px; padding: 10px 14px; font-size: 13px; margin-bottom: 16px;
}

/* ── App Shell ── */
.app-wrap { display: flex; height: 100vh; overflow: hidden; }

/* ── Sidebar ── */
.sidebar {
  width: var(--sidebar-w); flex-shrink: 0; background: var(--sidebar-bg);
  display: flex; flex-direction: column; overflow: hidden;
  box-shadow: 4px 0 20px rgba(0,0,0,.2); z-index: 100;
  transition: width .3s ease;
}
.sidebar.collapsed { width: 68px; }
.sb-header {
  padding: 20px 20px 16px; display: flex; align-items: center; gap: 12px;
  border-bottom: 1px solid rgba(255,255,255,.06);
}
.sb-logo {
  width: 40px; height: 40px; border-radius: 12px; flex-shrink: 0;
  background: linear-gradient(135deg, var(--primary), var(--accent));
  display: flex; align-items: center; justify-content: center;
}
.sb-logo svg { width: 22px; height: 22px; }
.sb-brand { overflow: hidden; }
.sb-brand-name { font-size: 16px; font-weight: 800; color: #fff; white-space: nowrap; }
.sb-brand-sub { font-size: 10px; color: rgba(255,255,255,.4); white-space: nowrap; }
.sb-nav { flex: 1; overflow-y: auto; padding: 12px 10px; }
.sb-section { margin-bottom: 6px; }
.sb-section-label {
  font-size: 9px; font-weight: 700; letter-spacing: 1.5px; text-transform: uppercase;
  color: rgba(255,255,255,.25); padding: 8px 10px 4px; white-space: nowrap; overflow: hidden;
}
.sb-item {
  display: flex; align-items: center; gap: 10px; padding: 10px 10px;
  border-radius: 10px; cursor: pointer; transition: all .2s; color: rgba(255,255,255,.55);
  position: relative; white-space: nowrap;
}
.sb-item:hover { background: rgba(255,255,255,.07); color: rgba(255,255,255,.9); }
.sb-item.active { background: rgba(99,102,241,.18); color: #fff; }
.sb-item.active::before {
  content: ''; position: absolute; left: 0; top: 50%; transform: translateY(-50%);
  width: 3px; height: 20px; background: var(--primary-light); border-radius: 0 3px 3px 0;
}
.sb-item-icon { width: 20px; height: 20px; flex-shrink: 0; }
.sb-item-label { font-size: 13.5px; font-weight: 500; overflow: hidden; }
.sb-sub { padding-left: 30px; }
.sb-sub .sb-item { padding: 8px 10px; font-size: 13px; }
.sb-footer { padding: 12px 10px; border-top: 1px solid rgba(255,255,255,.06); }
.user-pill {
  display: flex; align-items: center; gap: 10px; padding: 10px;
  border-radius: 10px; cursor: pointer; transition: background .2s;
}
.user-pill:hover { background: rgba(255,255,255,.07); }
.user-avatar {
  width: 36px; height: 36px; border-radius: 10px; flex-shrink: 0;
  background: linear-gradient(135deg, var(--primary), #8b5cf6);
  display: flex; align-items: center; justify-content: center;
  font-weight: 700; font-size: 14px; color: #fff;
}
.user-info { overflow: hidden; }
.user-name { font-size: 13px; font-weight: 600; color: #fff; white-space: nowrap; }
.user-role { font-size: 10px; color: rgba(255,255,255,.35); white-space: nowrap; }

/* ── Top Bar ── */
.topbar {
  height: var(--topbar-h); background: var(--card);
  border-bottom: 1px solid var(--border);
  display: flex; align-items: center; gap: 16px;
  padding: 0 24px; flex-shrink: 0;
  box-shadow: 0 1px 4px rgba(0,0,0,.04);
}
.topbar-toggle { background: none; border: none; cursor: pointer; color: var(--text-muted); padding: 6px; border-radius: 8px; transition: background .2s; }
.topbar-toggle:hover { background: var(--bg); }
.topbar-title { font-size: 17px; font-weight: 700; flex: 1; }
.topbar-right { display: flex; align-items: center; gap: 12px; }
.topbar-btn {
  width: 36px; height: 36px; border-radius: 9px; background: var(--bg);
  border: 1px solid var(--border); display: flex; align-items: center; justify-content: center;
  cursor: pointer; color: var(--text-muted); transition: all .2s;
}
.topbar-btn:hover { background: #e8edff; color: var(--primary); border-color: var(--primary-light); }

/* ── Main Content ── */
.main-wrap { flex: 1; display: flex; flex-direction: column; overflow: hidden; }
.page-content { flex: 1; overflow-y: auto; padding: 28px 28px 40px; }

/* ── Cards ── */
.card { background: var(--card); border-radius: var(--radius); box-shadow: var(--shadow); border: 1px solid var(--border); }
.card-header {
  display: flex; align-items: center; justify-content: space-between;
  padding: 18px 22px; border-bottom: 1px solid var(--border);
}
.card-title { font-size: 15px; font-weight: 700; }
.card-body { padding: 22px; }

/* ── Stat Widgets ── */
.stats-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 24px; }
.stat-card {
  background: var(--card); border-radius: var(--radius); padding: 22px;
  border: 1px solid var(--border); box-shadow: var(--shadow);
  position: relative; overflow: hidden; transition: transform .2s, box-shadow .2s;
}
.stat-card:hover { transform: translateY(-2px); box-shadow: var(--shadow-lg); }
.stat-card::before {
  content: ''; position: absolute; top: 0; right: 0;
  width: 80px; height: 80px; border-radius: 0 12px 0 100%;
  opacity: .12;
}
.stat-card.blue::before { background: var(--primary); }
.stat-card.teal::before { background: var(--accent); }
.stat-card.green::before { background: var(--success); }
.stat-icon {
  width: 46px; height: 46px; border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-bottom: 16px;
}
.stat-icon.blue { background: linear-gradient(135deg, #ede9fe, #c7d2fe); color: var(--primary-dark); }
.stat-icon.teal { background: linear-gradient(135deg, #cffafe, #a5f3fc); color: #0891b2; }
.stat-icon.green { background: linear-gradient(135deg, #d1fae5, #a7f3d0); color: #059669; }
.stat-value { font-size: 34px; font-weight: 800; color: var(--text); margin-bottom: 4px; line-height: 1; }
.stat-label { font-size: 13px; color: var(--text-muted); font-weight: 500; }
.stat-change { display: inline-flex; align-items: center; gap: 4px; font-size: 12px; margin-top: 10px; padding: 2px 8px; border-radius: 20px; font-weight: 600; }
.stat-change.up { background: #dcfce7; color: #16a34a; }
.stat-change.down { background: #fee2e2; color: #dc2626; }

/* ── Filters ── */
.filter-bar {
  display: flex; flex-wrap: wrap; gap: 12px; align-items: flex-end;
  background: var(--card); padding: 16px 20px; border-radius: var(--radius);
  border: 1px solid var(--border); margin-bottom: 24px; box-shadow: var(--shadow);
}
.filter-group { display: flex; flex-direction: column; gap: 4px; }
.filter-label { font-size: 11px; font-weight: 600; color: var(--text-muted); text-transform: uppercase; letter-spacing: .5px; }
.filter-select, .filter-input {
  padding: 8px 14px; border: 1px solid var(--border); border-radius: 8px;
  font-size: 13.5px; font-family: inherit; color: var(--text);
  background: var(--bg); outline: none; transition: all .2s; cursor: pointer;
  min-width: 150px;
}
.filter-select:focus, .filter-input:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(99,102,241,.12); background: #fff; }

/* ── Buttons ── */
.btn {
  display: inline-flex; align-items: center; gap: 6px;
  padding: 9px 18px; border-radius: 9px; font-size: 13.5px; font-weight: 600;
  font-family: inherit; cursor: pointer; border: none; transition: all .2s; white-space: nowrap;
}
.btn-primary { background: var(--primary); color: #fff; }
.btn-primary:hover { background: var(--primary-dark); transform: translateY(-1px); box-shadow: 0 4px 14px rgba(99,102,241,.4); }
.btn-outline { background: transparent; color: var(--primary); border: 1.5px solid var(--primary); }
.btn-outline:hover { background: rgba(99,102,241,.07); }
.btn-sm { padding: 6px 12px; font-size: 12.5px; border-radius: 7px; }
.btn-danger { background: var(--danger); color: #fff; }
.btn-danger:hover { background: #dc2626; }
.btn-success { background: var(--success); color: #fff; }
.btn-success:hover { background: #059669; }
.btn-warning { background: var(--warning); color: #fff; }
.btn-warning:hover { background: #d97706; }
.btn-secondary { background: #f1f5f9; color: var(--text-muted); border: 1px solid var(--border); }
.btn-secondary:hover { background: #e2e8f0; }
.btn-icon {
  width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;
  border-radius: 8px; cursor: pointer; border: none; transition: all .2s;
}
.btn-icon.edit { background: #fef9c3; color: #a16207; }
.btn-icon.edit:hover { background: #fde047; }
.btn-icon.delete { background: #fee2e2; color: #b91c1c; }
.btn-icon.delete:hover { background: #fca5a5; }
.btn-icon.blue { background: #dbeafe; color: #1d4ed8; }
.btn-icon.blue:hover { background: #bfdbfe; }

/* ── Tables ── */
.table-wrap { overflow-x: auto; }
table { width: 100%; border-collapse: collapse; font-size: 13.5px; }
thead tr { background: #f8fafc; }
th {
  padding: 12px 16px; text-align: left; font-size: 11.5px; font-weight: 700;
  color: var(--text-muted); text-transform: uppercase; letter-spacing: .5px;
  border-bottom: 2px solid var(--border); white-space: nowrap; cursor: pointer;
  user-select: none; transition: color .2s;
}
th:hover { color: var(--primary); }
th .sort-icon { display: inline-block; margin-left: 4px; opacity: .4; font-size: 10px; }
th.sorted .sort-icon { opacity: 1; color: var(--primary); }
td { padding: 12px 16px; border-bottom: 1px solid #f1f5f9; vertical-align: middle; }
tr:last-child td { border-bottom: none; }
tr:hover td { background: #fafbff; }
.badge {
  display: inline-flex; align-items: center; gap: 4px;
  padding: 3px 10px; border-radius: 20px; font-size: 11.5px; font-weight: 600;
}
.badge-success { background: #dcfce7; color: #15803d; }
.badge-danger  { background: #fee2e2; color: #b91c1c; }
.badge-warning { background: #fef3c7; color: #b45309; }
.badge-info    { background: #dbeafe; color: #1d4ed8; }
.badge-purple  { background: #ede9fe; color: #6d28d9; }
.action-btns { display: flex; align-items: center; gap: 6px; }

/* ── Modal ── */
.modal-overlay {
  position: fixed; inset: 0; background: rgba(0,0,0,.5); backdrop-filter: blur(4px);
  z-index: 1000; display: flex; align-items: center; justify-content: center; padding: 20px;
}
.modal {
  background: #fff; border-radius: 16px; width: 100%; max-width: 560px;
  box-shadow: 0 24px 64px rgba(0,0,0,.2); max-height: 90vh; overflow-y: auto;
  animation: modalIn .2s ease-out;
}
.modal-lg { max-width: 760px; }
@keyframes modalIn { from { opacity: 0; transform: translateY(-16px) scale(.97); } }
.modal-header { display: flex; align-items: center; justify-content: space-between; padding: 20px 24px; border-bottom: 1px solid var(--border); }
.modal-title { font-size: 17px; font-weight: 700; }
.modal-close { width: 32px; height: 32px; border-radius: 8px; border: none; background: var(--bg); cursor: pointer; display: flex; align-items: center; justify-content: center; color: var(--text-muted); transition: background .2s; }
.modal-close:hover { background: #fee2e2; color: var(--danger); }
.modal-body { padding: 24px; }
.modal-footer { padding: 16px 24px; border-top: 1px solid var(--border); display: flex; gap: 10px; justify-content: flex-end; }

/* ── Form Elements ── */
.field-group { margin-bottom: 18px; }
.field-label { display: block; font-size: 12.5px; font-weight: 600; color: var(--text-muted); margin-bottom: 6px; }
.field-input, .field-select, .field-textarea {
  width: 100%; padding: 10px 14px; border: 1.5px solid var(--border); border-radius: 9px;
  font-size: 14px; font-family: inherit; color: var(--text); outline: none; transition: all .2s;
  background: #fff;
}
.field-input:focus, .field-select:focus, .field-textarea:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(99,102,241,.12); }
.field-textarea { resize: vertical; min-height: 90px; }
.field-hint { font-size: 11.5px; color: var(--text-muted); margin-top: 4px; }
.field-error { font-size: 11.5px; color: var(--danger); margin-top: 4px; }
.form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
.field-file {
  width: 100%; padding: 10px 14px; border: 1.5px dashed var(--border); border-radius: 9px;
  font-size: 14px; font-family: inherit; outline: none; cursor: pointer;
  transition: border-color .2s;
}
.field-file:hover { border-color: var(--primary); }

/* ── Radio group ── */
.radio-group { display: flex; gap: 16px; flex-wrap: wrap; }
.radio-option { display: flex; align-items: center; gap: 6px; cursor: pointer; }
.radio-option input { accent-color: var(--primary); }
.radio-label { font-size: 14px; }

/* ── Hierarchical tree ── */
.tree-parent { border: 1px solid var(--border); border-radius: 10px; margin-bottom: 10px; overflow: hidden; }
.tree-parent-row {
  display: flex; align-items: center; gap: 10px; padding: 12px 16px;
  background: #f8fafc; cursor: pointer; transition: background .15s;
}
.tree-parent-row:hover { background: #eff6ff; }
.tree-toggle { width: 22px; height: 22px; border-radius: 6px; border: 1.5px solid var(--border); display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-size: 11px; transition: all .2s; }
.tree-toggle.open { background: var(--primary); border-color: var(--primary); color: #fff; }
.tree-children table { border-radius: 0; }
.tree-children td { padding: 10px 16px 10px 42px; }

/* ── Pagination ── */
.pagination { display: flex; align-items: center; gap: 4px; margin-top: 16px; }
.page-btn {
  width: 34px; height: 34px; border-radius: 8px; border: 1.5px solid var(--border);
  background: var(--card); display: flex; align-items: center; justify-content: center;
  cursor: pointer; font-size: 13px; font-weight: 600; color: var(--text-muted);
  transition: all .2s;
}
.page-btn:hover { border-color: var(--primary); color: var(--primary); }
.page-btn.active { background: var(--primary); border-color: var(--primary); color: #fff; }
.page-btn:disabled { opacity: .4; cursor: not-allowed; }

/* ── Toast Enhanced ── */
.toast-container { position: fixed; top: 24px; right: 24px; z-index: 9999; display: flex; flex-direction: column; gap: 10px; pointer-events: none; }
.toast {
  display: flex; align-items: flex-start; gap: 12px; padding: 16px 20px;
  border-radius: 16px; box-shadow: 0 16px 40px rgba(0,0,0,.18), 0 4px 12px rgba(0,0,0,.08);
  font-size: 14px; font-weight: 500; min-width: 300px; max-width: 420px;
  animation: toastIn .4s cubic-bezier(0.34,1.56,0.64,1);
  transition: all .35s ease; position: relative; overflow: hidden;
  pointer-events: all; backdrop-filter: blur(12px);
}
@keyframes toastIn { from { opacity: 0; transform: translateX(60px) scale(.9); } to { opacity:1; transform: translateX(0) scale(1); } }
.toast-icon { width: 36px; height: 36px; border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-size: 18px; }
.toast-content { flex: 1; }
.toast-title { font-size: 13px; font-weight: 700; margin-bottom: 2px; }
.toast-msg { font-size: 13px; opacity: .85; line-height: 1.4; }
.toast-close { position: absolute; top: 10px; right: 12px; background: none; border: none; cursor: pointer; opacity: .5; font-size: 16px; transition: opacity .2s; }
.toast-close:hover { opacity: 1; }
.toast-bar { position: absolute; bottom: 0; left: 0; height: 3px; border-radius: 0 0 0 16px; animation: toastBar 3.5s linear forwards; }
@keyframes toastBar { from { width: 100%; } to { width: 0%; } }
.toast.success { background: linear-gradient(135deg, #f0fdf4, #dcfce7); border: 1.5px solid #86efac; color: #15803d; }
.toast.success .toast-icon { background: #dcfce7; color: #16a34a; }
.toast.success .toast-bar { background: #22c55e; }
.toast.error { background: linear-gradient(135deg, #fff1f2, #ffe4e6); border: 1.5px solid #fca5a5; color: #b91c1c; }
.toast.error .toast-icon { background: #fee2e2; color: #dc2626; }
.toast.error .toast-bar { background: #ef4444; }
.toast.warning { background: linear-gradient(135deg, #fffbeb, #fef3c7); border: 1.5px solid #fcd34d; color: #92400e; }
.toast.warning .toast-icon { background: #fef3c7; color: #d97706; }
.toast.warning .toast-bar { background: #f59e0b; }
.toast.info { background: linear-gradient(135deg, #eff6ff, #dbeafe); border: 1.5px solid #93c5fd; color: #1d4ed8; }
.toast.info .toast-icon { background: #dbeafe; color: #2563eb; }
.toast.info .toast-bar { background: #3b82f6; }

/* ── Delete Confirm Modal ── */
.delete-confirm-overlay {
  position: fixed; inset: 0; background: rgba(0,0,0,.6); backdrop-filter: blur(6px);
  z-index: 2000; display: flex; align-items: center; justify-content: center; padding: 20px;
}
.delete-confirm-box {
  background: #fff; border-radius: 20px; padding: 40px 36px; width: 100%; max-width: 420px;
  box-shadow: 0 32px 80px rgba(0,0,0,.25); text-align: center;
  animation: modalIn .25s cubic-bezier(0.34,1.56,0.64,1);
}
.delete-icon-wrap {
  width: 72px; height: 72px; border-radius: 50%; background: #fff1f2;
  display: flex; align-items: center; justify-content: center; margin: 0 auto 20px;
  border: 3px solid #fecaca; animation: pulse-danger 2s infinite;
}
@keyframes pulse-danger { 0%,100%{ box-shadow: 0 0 0 0 rgba(239,68,68,.3); } 50%{ box-shadow: 0 0 0 12px rgba(239,68,68,0); } }
.delete-confirm-title { font-size: 20px; font-weight: 800; color: #1e293b; margin-bottom: 10px; }
.delete-confirm-desc { font-size: 14px; color: #64748b; line-height: 1.6; margin-bottom: 28px; }
.delete-confirm-item { font-weight: 700; color: #ef4444; }
.delete-confirm-actions { display: flex; gap: 12px; }
.delete-confirm-actions button { flex: 1; padding: 13px; border-radius: 10px; font-size: 14px; font-weight: 700; cursor: pointer; border: none; transition: all .2s; font-family: inherit; }
.btn-cancel-del { background: #f1f5f9; color: #64748b; border: 1.5px solid #e2e8f0 !important; }
.btn-cancel-del:hover { background: #e2e8f0; }
.btn-do-del { background: linear-gradient(135deg, #ef4444, #dc2626); color: #fff; }
.btn-do-del:hover { transform: translateY(-1px); box-shadow: 0 6px 20px rgba(239,68,68,.4); }

/* ── Landing Page ── */
.landing-wrap {
  min-height: 100vh; background: #0a0f1e; position: relative; overflow: hidden;
  font-family: 'Inter', sans-serif;
}
.landing-bg {
  position: absolute; inset: 0; overflow: hidden; pointer-events: none;
}
.landing-orb {
  position: absolute; border-radius: 50%; filter: blur(120px); opacity: .25; animation: floatOrb 8s ease-in-out infinite alternate;
}
.landing-orb-1 { width: 600px; height: 600px; background: #6366f1; top: -200px; left: -100px; animation-delay: 0s; }
.landing-orb-2 { width: 400px; height: 400px; background: #06b6d4; bottom: -100px; right: 10%; animation-delay: -3s; }
.landing-orb-3 { width: 300px; height: 300px; background: #8b5cf6; top: 40%; right: -50px; animation-delay: -6s; }
@keyframes floatOrb { from { transform: translate(0,0) scale(1); } to { transform: translate(30px, -20px) scale(1.05); } }
.landing-grid {
  position: absolute; inset: 0;
  background-image: linear-gradient(rgba(99,102,241,.06) 1px, transparent 1px), linear-gradient(90deg, rgba(99,102,241,.06) 1px, transparent 1px);
  background-size: 60px 60px;
}
.landing-nav {
  position: relative; z-index: 10; display: flex; align-items: center; justify-content: space-between;
  padding: 24px 60px; border-bottom: 1px solid rgba(255,255,255,.06);
}
.landing-nav-logo { display: flex; align-items: center; gap: 12px; }
.landing-nav-icon {
  width: 44px; height: 44px; border-radius: 12px; flex-shrink: 0;
  background: linear-gradient(135deg, #6366f1, #06b6d4);
  display: flex; align-items: center; justify-content: center;
  box-shadow: 0 8px 24px rgba(99,102,241,.5);
}
.landing-nav-name { font-size: 20px; font-weight: 800; color: #fff; }
.landing-nav-btn {
  padding: 10px 24px; border-radius: 10px; font-size: 14px; font-weight: 700;
  background: rgba(255,255,255,.08); border: 1.5px solid rgba(255,255,255,.15);
  color: #fff; cursor: pointer; transition: all .2s; font-family: inherit;
}
.landing-nav-btn:hover { background: rgba(255,255,255,.15); border-color: rgba(255,255,255,.3); }
.landing-hero {
  position: relative; z-index: 10; text-align: center; padding: 100px 40px 80px;
  max-width: 900px; margin: 0 auto;
}
.landing-badge {
  display: inline-flex; align-items: center; gap: 8px; padding: 8px 18px;
  background: rgba(99,102,241,.15); border: 1px solid rgba(99,102,241,.3);
  border-radius: 50px; margin-bottom: 32px; font-size: 13px; color: #a5b4fc;
  font-weight: 600; letter-spacing: .3px;
}
.landing-badge-dot { width: 6px; height: 6px; border-radius: 50%; background: #818cf8; animation: blink 1.5s infinite; }
@keyframes blink { 0%,100%{opacity:1} 50%{opacity:.3} }
.landing-hero-title {
  font-size: clamp(36px, 6vw, 72px); font-weight: 900; color: #fff; line-height: 1.1;
  margin-bottom: 24px; letter-spacing: -1px;
}
.landing-hero-title .gradient-text {
  background: linear-gradient(135deg, #818cf8, #06b6d4, #34d399);
  -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;
}
.landing-hero-desc {
  font-size: 18px; color: rgba(255,255,255,.6); line-height: 1.7;
  max-width: 600px; margin: 0 auto 48px;
}
.landing-cta-group { display: flex; align-items: center; justify-content: center; gap: 16px; flex-wrap: wrap; }
.landing-btn-primary {
  padding: 16px 36px; border-radius: 12px; font-size: 16px; font-weight: 700;
  background: linear-gradient(135deg, #6366f1, #4f46e5);
  color: #fff; border: none; cursor: pointer; transition: all .25s;
  font-family: inherit; box-shadow: 0 8px 32px rgba(99,102,241,.45);
  display: flex; align-items: center; gap: 8px;
}
.landing-btn-primary:hover { transform: translateY(-2px); box-shadow: 0 16px 48px rgba(99,102,241,.55); }
.landing-btn-secondary {
  padding: 16px 36px; border-radius: 12px; font-size: 16px; font-weight: 600;
  background: rgba(255,255,255,.08); border: 1.5px solid rgba(255,255,255,.2);
  color: rgba(255,255,255,.85); cursor: pointer; transition: all .25s; font-family: inherit;
}
.landing-btn-secondary:hover { background: rgba(255,255,255,.14); }
.landing-stats {
  position: relative; z-index: 10; display: grid; grid-template-columns: repeat(4, 1fr);
  gap: 1px; background: rgba(255,255,255,.08); max-width: 900px; margin: 0 auto 80px;
  border: 1px solid rgba(255,255,255,.08); border-radius: 20px; overflow: hidden;
}
.landing-stat {
  padding: 32px 24px; text-align: center; background: rgba(255,255,255,.03);
  transition: background .2s;
}
.landing-stat:hover { background: rgba(255,255,255,.06); }
.landing-stat-val { font-size: 36px; font-weight: 900; color: #fff; margin-bottom: 6px; }
.landing-stat-label { font-size: 13px; color: rgba(255,255,255,.45); font-weight: 500; }
.landing-features {
  position: relative; z-index: 10; display: grid; grid-template-columns: repeat(3, 1fr);
  gap: 20px; max-width: 1100px; margin: 0 auto 80px; padding: 0 40px;
}
.landing-feature {
  background: rgba(255,255,255,.04); border: 1px solid rgba(255,255,255,.08);
  border-radius: 20px; padding: 32px 28px; transition: all .3s;
}
.landing-feature:hover { background: rgba(255,255,255,.07); border-color: rgba(99,102,241,.3); transform: translateY(-4px); }
.landing-feature-icon {
  width: 52px; height: 52px; border-radius: 14px; display: flex; align-items: center; justify-content: center;
  margin-bottom: 20px; font-size: 24px;
}
.landing-feature-icon.blue { background: rgba(99,102,241,.2); }
.landing-feature-icon.cyan { background: rgba(6,182,212,.2); }
.landing-feature-icon.green { background: rgba(16,185,129,.2); }
.landing-feature-title { font-size: 17px; font-weight: 700; color: #fff; margin-bottom: 10px; }
.landing-feature-desc { font-size: 14px; color: rgba(255,255,255,.5); line-height: 1.7; }
.landing-footer {
  position: relative; z-index: 10; text-align: center; padding: 32px;
  border-top: 1px solid rgba(255,255,255,.06); color: rgba(255,255,255,.3); font-size: 13px;
}

/* ── Sewa Lapangan (Customer View) ── */
.customer-header {
  background: linear-gradient(135deg, #6366f1 0%, #4f46e5 50%, #06b6d4 100%);
  border-radius: var(--radius); padding: 32px 28px; margin-bottom: 28px; position: relative; overflow: hidden;
}
.customer-header::before {
  content: ''; position: absolute; inset: 0;
  background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Ccircle cx='30' cy='30' r='4'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
}
.customer-header-title { font-size: 26px; font-weight: 800; color: #fff; margin-bottom: 8px; position: relative; }
.customer-header-sub { font-size: 14px; color: rgba(255,255,255,.75); position: relative; }
.sewa-filter-bar {
  display: flex; gap: 12px; align-items: center; flex-wrap: wrap; margin-bottom: 24px;
  background: var(--card); padding: 16px 20px; border-radius: var(--radius);
  border: 1px solid var(--border); box-shadow: var(--shadow);
}
.sewa-card {
  background: var(--card); border: 1px solid var(--border); border-radius: 16px;
  overflow: hidden; box-shadow: var(--shadow); transition: all .25s ease;
  display: flex; flex-direction: column;
}
.sewa-card:hover { transform: translateY(-6px); box-shadow: 0 20px 48px rgba(0,0,0,.12); border-color: var(--primary-light); }
.sewa-card-img { width: 100%; height: 200px; object-fit: cover; background: linear-gradient(135deg, #e2e8f0, #cbd5e1); position: relative; }
.sewa-card-status {
  position: absolute; top: 12px; left: 12px; padding: 5px 12px; border-radius: 20px;
  font-size: 11.5px; font-weight: 700; letter-spacing: .3px;
}
.sewa-card-status.available { background: rgba(16,185,129,.9); color: #fff; }
.sewa-card-status.busy { background: rgba(239,68,68,.9); color: #fff; }
.sewa-card-sport-badge {
  position: absolute; top: 12px; right: 12px; width: 36px; height: 36px; border-radius: 50%;
  background: rgba(255,255,255,.9); display: flex; align-items: center; justify-content: center;
  font-size: 18px; box-shadow: 0 4px 12px rgba(0,0,0,.15);
}
.sewa-card-body { padding: 20px; flex: 1; display: flex; flex-direction: column; }
.sewa-card-venue { font-size: 11px; font-weight: 700; color: var(--primary); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 6px; }
.sewa-card-name { font-size: 18px; font-weight: 800; color: var(--text); margin-bottom: 10px; line-height: 1.3; }
.sewa-card-info { display: flex; flex-direction: column; gap: 6px; margin-bottom: 14px; }
.sewa-card-info-row { display: flex; align-items: center; gap: 8px; font-size: 13px; color: var(--text-muted); }
.sewa-card-info-icon { width: 16px; text-align: center; }
.sewa-card-divider { height: 1px; background: var(--border); margin: 14px 0; }
.sewa-card-price { display: flex; align-items: baseline; gap: 6px; margin-bottom: 14px; }
.sewa-card-price-from { font-size: 12px; color: var(--text-muted); }
.sewa-card-price-val { font-size: 22px; font-weight: 900; color: var(--primary); }
.sewa-card-price-unit { font-size: 12px; color: var(--text-muted); }
.sewa-card-akreditasi { display: inline-flex; align-items: center; gap: 4px; font-size: 12px; font-weight: 700; padding: 4px 10px; border-radius: 6px; }
.sewa-card-akreditasi.A { background: #dcfce7; color: #15803d; }
.sewa-card-akreditasi.B { background: #dbeafe; color: #1d4ed8; }
.sewa-card-akreditasi.C { background: #fef3c7; color: #92400e; }
.sewa-card-akreditasi.Unggul { background: #ede9fe; color: #6d28d9; }
.sewa-card-footer { margin-top: auto; display: flex; gap: 8px; }
.sewa-btn-book {
  flex: 1; padding: 11px; border-radius: 10px; font-size: 13.5px; font-weight: 700;
  background: linear-gradient(135deg, var(--primary), var(--primary-dark));
  color: #fff; border: none; cursor: pointer; transition: all .2s; font-family: inherit;
  display: flex; align-items: center; justify-content: center; gap: 6px;
}
.sewa-btn-book:hover { transform: translateY(-1px); box-shadow: 0 6px 20px rgba(99,102,241,.4); }
.sewa-btn-detail {
  padding: 11px 16px; border-radius: 10px; font-size: 13.5px; font-weight: 600;
  background: var(--bg); color: var(--text-muted); border: 1.5px solid var(--border);
  cursor: pointer; transition: all .2s; font-family: inherit;
}
.sewa-btn-detail:hover { background: var(--border); color: var(--text); }

/* ── Admin Lapangan Table View ── */
.admin-lapangan-header {
  display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px; flex-wrap: wrap; gap: 12px;
}
.admin-lapangan-header-left h2 { font-size: 22px; font-weight: 800; color: var(--text); margin-bottom: 4px; }
.admin-lapangan-header-left p { font-size: 13px; color: var(--text-muted); }
.admin-search-group { display: flex; gap: 10px; align-items: center; flex-wrap: wrap; }
.lapangan-table-thumb { width: 52px; height: 40px; border-radius: 8px; object-fit: cover; background: #f1f5f9; border: 1.5px solid var(--border); }
.lapangan-table-thumb-placeholder {
  width: 52px; height: 40px; border-radius: 8px; background: linear-gradient(135deg, #e2e8f0, #cbd5e1);
  display: flex; align-items: center; justify-content: center; border: 1.5px solid var(--border); font-size: 16px;
}
.status-dot { width: 8px; height: 8px; border-radius: 50%; display: inline-block; margin-right: 6px; }
.status-dot.active { background: #22c55e; }
.status-dot.inactive { background: #ef4444; }

/* ── Chart container ── */
.chart-area { position: relative; height: 280px; }

/* ── Occupancy bar ── */
.occ-bar { height: 8px; background: #e2e8f0; border-radius: 4px; overflow: hidden; }
.occ-fill { height: 100%; border-radius: 4px; transition: width .8s ease; }

/* ── Stars ── */
.stars { color: #f59e0b; letter-spacing: 1px; }

/* ── Search bar ── */
.search-bar {
  display: flex; align-items: center; gap: 8px; padding: 0 14px;
  border: 1.5px solid var(--border); border-radius: 9px; background: var(--bg);
  transition: all .2s;
}
.search-bar:focus-within { border-color: var(--primary); background: #fff; box-shadow: 0 0 0 3px rgba(99,102,241,.12); }
.search-bar input { border: none; background: transparent; outline: none; font-size: 14px; font-family: inherit; padding: 9px 0; flex: 1; color: var(--text); }
.search-bar svg { flex-shrink: 0; color: var(--text-muted); }

/* ── Quill override ── */
.ql-container { font-family: 'Inter', sans-serif; }
.ql-editor { min-height: 120px; }

/* ── Tip Card ── */
.tip-card {
  background: linear-gradient(135deg, #f0f9ff, #e0f2fe);
  border: 1px solid #bae6fd; border-radius: 12px; padding: 20px 24px;
  margin-top: 24px;
}
.tip-card-title { font-size: 14px; font-weight: 700; color: #0369a1; margin-bottom: 10px; display: flex; align-items: center; gap: 6px; }
.tip-list { list-style: none; display: flex; flex-direction: column; gap: 6px; }
.tip-list li { font-size: 13px; color: #0c4a6e; display: flex; align-items: flex-start; gap: 6px; }
.tip-list li::before { content: '→'; color: #0369a1; flex-shrink: 0; margin-top: 1px; }

/* ── Page Tabs ── */
.page-tabs { display: flex; gap: 4px; background: #f1f5f9; border-radius: 10px; padding: 4px; margin-bottom: 24px; }
.page-tab { padding: 8px 20px; border-radius: 8px; font-size: 13.5px; font-weight: 600; cursor: pointer; color: var(--text-muted); transition: all .2s; border: none; background: none; font-family: inherit; }
.page-tab.active { background: var(--card); color: var(--primary); box-shadow: 0 1px 4px rgba(0,0,0,.08); }

/* ── Breadcrumb ── */
.breadcrumb { display: flex; align-items: center; gap: 6px; font-size: 13px; color: var(--text-muted); margin-bottom: 20px; }
.breadcrumb span { color: var(--text); font-weight: 600; }

/* ── Empty state ── */
.empty-state { text-align: center; padding: 60px 20px; color: var(--text-muted); }
.empty-state svg { width: 56px; height: 56px; opacity: .3; margin: 0 auto 12px; display: block; }
.empty-state p { font-size: 14px; }

/* ── Loading ── */
.loading-spinner { display: flex; align-items: center; justify-content: center; padding: 40px; }
.spinner { width: 32px; height: 32px; border: 3px solid var(--border); border-top-color: var(--primary); border-radius: 50%; animation: spin .7s linear infinite; }
@keyframes spin { to { transform: rotate(360deg); } }

/* ── Responsive ── */
@media (max-width: 1024px) { .stats-grid { grid-template-columns: repeat(2, 1fr); } }
@media (max-width: 768px) {
  .sidebar { position: fixed; transform: translateX(-100%); }
  .sidebar.mobile-open { transform: translateX(0); }
  .stats-grid { grid-template-columns: 1fr; }
  .form-row { grid-template-columns: 1fr; }
}

/* ── Premium Card Grid ── */
.lapangan-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
  gap: 24px;
  padding: 8px 0;
}
.premium-card {
  background: var(--card);
  border: 1px solid var(--border);
  border-radius: 16px;
  overflow: hidden;
  box-shadow: var(--shadow);
  transition: transform 0.2s ease, box-shadow 0.2s ease;
  position: relative;
  display: flex;
  flex-direction: column;
}
.premium-card:hover {
  transform: translateY(-4px);
  box-shadow: var(--shadow-lg);
}
.premium-card-img-wrap {
  width: 100%;
  height: 180px;
  background: #f1f5f9;
  position: relative;
  overflow: hidden;
}
.premium-card-img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: transform 0.3s ease;
}
.premium-card:hover .premium-card-img {
  transform: scale(1.05);
}
.premium-card-placeholder {
  width: 100%;
  height: 100%;
  display: flex;
  align-items: center;
  justify-content: center;
  background: linear-gradient(135deg, #e2e8f0, #cbd5e1);
  color: var(--text-muted);
}
.premium-card-body {
  padding: 18px;
  display: flex;
  flex-direction: column;
  flex-grow: 1;
}
.premium-card-venue {
  font-size: 11px;
  font-weight: 700;
  color: var(--text-muted);
  text-transform: uppercase;
  letter-spacing: 0.8px;
  margin-bottom: 6px;
}
.premium-card-title {
  font-size: 18px;
  font-weight: 700;
  color: var(--text);
  margin-bottom: 8px;
  line-height: 1.3;
}
.premium-card-meta {
  display: flex;
  align-items: center;
  gap: 6px;
  font-size: 13px;
  color: var(--text-muted);
  margin-bottom: 12px;
}
.premium-card-meta .star {
  color: var(--warning);
  font-size: 14px;
}
.premium-card-sport {
  display: flex;
  align-items: center;
  gap: 8px;
  font-size: 13px;
  font-weight: 500;
  color: var(--text);
  margin-top: auto;
  padding-top: 12px;
  border-top: 1px solid var(--border);
}
.premium-card-price-row {
  display: flex;
  align-items: baseline;
  gap: 4px;
  margin-top: 10px;
}
.premium-card-price-label {
  font-size: 12px;
  color: var(--text-muted);
}
.premium-card-price-val {
  font-size: 16px;
  font-weight: 800;
  color: var(--primary);
}
.premium-card-price-unit {
  font-size: 12px;
  color: var(--text-muted);
}

/* Floating Actions in Card */
.premium-card-actions {
  position: absolute;
  top: 12px;
  right: 12px;
  display: flex;
  gap: 8px;
  z-index: 10;
}
.premium-btn-floating {
  width: 34px;
  height: 34px;
  border-radius: 50%;
  border: 1px solid rgba(255, 255, 255, 0.2);
  background: rgba(255, 255, 255, 0.85);
  backdrop-filter: blur(8px);
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  box-shadow: 0 4px 12px rgba(0,0,0,0.15);
  transition: all 0.2s ease;
  font-size: 14px;
}
.premium-btn-floating:hover {
  background: #ffffff;
  transform: scale(1.1);
}
.premium-btn-floating.delete:hover {
  color: var(--danger);
  border-color: rgba(239, 68, 68, 0.2);
}
</style>
</head>
<body>
<div id="app" x-data="sportsApp()" x-init="init()">

  <!-- △△△ TOAST NOTIFICATIONS △△△ -->
  <div class="toast-container">
    <template x-for="(t, i) in toasts" :key="t.id">
      <div class="toast" :class="t.type" x-show="t.visible" x-transition>
        <div class="toast-icon">
          <template x-if="t.type==='success'"><span>✅</span></template>
          <template x-if="t.type==='error'"><span>❌</span></template>
          <template x-if="t.type==='warning'"><span>⚠️</span></template>
          <template x-if="t.type==='info'"><span>ℹ️</span></template>
        </div>
        <div class="toast-content">
          <div class="toast-title" x-text="t.type==='success'?'Berhasil':t.type==='error'?'Terjadi Kesalahan':t.type==='warning'?'Perhatian':'Informasi'"></div>
          <div class="toast-msg" x-text="t.msg"></div>
        </div>
        <button class="toast-close" @click="t.visible=false">✕</button>
        <div class="toast-bar"></div>
      </div>
    </template>
  </div>

  <!-- △△△ DELETE CONFIRMATION MODAL △△△ -->
  <div class="delete-confirm-overlay" x-show="deleteConfirm.show" x-transition @click.self="deleteConfirm.show=false">
    <div class="delete-confirm-box">
      <div class="delete-icon-wrap">
        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#ef4444" stroke-width="2.5">
          <polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4a1 1 0 011-1h4a1 1 0 011 1v2"/>
        </svg>
      </div>
      <div class="delete-confirm-title">Konfirmasi Penghapusan</div>
      <div class="delete-confirm-desc">
        Anda akan menghapus <span class="delete-confirm-item" x-text="String.fromCharCode(34) + (deleteConfirm.name||'item ini') + String.fromCharCode(34)"></span>.<br>
        Tindakan ini <strong>tidak dapat dibatalkan</strong> dan semua data terkait akan ikut terhapus.
      </div>
      <div class="delete-confirm-actions">
        <button class="btn-cancel-del" @click="deleteConfirm.show=false">Batal</button>
        <button class="btn-do-del" @click="deleteConfirm.onConfirm(); deleteConfirm.show=false">
          🗑️ Hapus Sekarang
        </button>
      </div>
    </div>
  </div>

    <!-- △△△ LANDING PAGE △△△ -->
  <div class="landing-wrap" x-show="showLanding" x-transition>
    <div class="landing-bg">
      <div class="landing-grid"></div>
      <div class="landing-orb landing-orb-1"></div>
      <div class="landing-orb landing-orb-2"></div>
      <div class="landing-orb landing-orb-3"></div>
    </div>
    <nav class="landing-nav">
      <div class="landing-nav-logo">
        <div class="landing-nav-icon">
          <svg width="24" height="24" viewBox="0 0 24 24" fill="white"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
        </div>
        <div class="landing-nav-name">SportSpace</div>
      </div>
      <button class="landing-nav-btn" @click="showLanding=false">Masuk ke Sistem →</button>
    </nav>
    <div class="landing-hero">
      <div class="landing-badge">
        <div class="landing-badge-dot"></div>
        Platform Manajemen Lapangan Olahraga #1
      </div>
      <h1 class="landing-hero-title">
        Kelola Lapangan Olahraga<br>
        <span class="gradient-text">Lebih Cerdas &amp; Efisien</span>
      </h1>
      <p class="landing-hero-desc">
        SportSpace adalah platform manajemen terintegrasi untuk mengoptimalkan operasional, reservasi, dan kualitas lapangan olahraga Anda dari satu dashboard terpadu.
      </p>
      <div class="landing-cta-group">
        <button class="landing-btn-primary" @click="showLanding=false">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
          Mulai Sekarang
        </button>
        <button class="landing-btn-secondary" @click="showLanding=false">Lihat Demo</button>
      </div>
    </div>
    <div class="landing-stats">
      <div class="landing-stat"><div class="landing-stat-val">500+</div><div class="landing-stat-label">Lapangan Terkelola</div></div>
      <div class="landing-stat"><div class="landing-stat-val">50+</div><div class="landing-stat-label">Kota di Indonesia</div></div>
      <div class="landing-stat"><div class="landing-stat-val">10K+</div><div class="landing-stat-label">Pengguna Aktif</div></div>
      <div class="landing-stat"><div class="landing-stat-val">99.9%</div><div class="landing-stat-label">Uptime Sistem</div></div>
    </div>
    <div class="landing-features">
      <div class="landing-feature">
        <div class="landing-feature-icon blue">📊</div>
        <div class="landing-feature-title">Dashboard Analitik Real-time</div>
        <div class="landing-feature-desc">Pantau tingkat keterisian, pendapatan, dan performa lapangan secara real-time dengan grafik interaktif yang komprehensif.</div>
      </div>
      <div class="landing-feature">
        <div class="landing-feature-icon cyan">🏙️</div>
        <div class="landing-feature-title">Manajemen Multi-Cabang</div>
        <div class="landing-feature-desc">Kelola puluhan cabang dan ratusan lapangan dari satu platform terpusat dengan sistem hierarki yang terstruktur rapi.</div>
      </div>
      <div class="landing-feature">
        <div class="landing-feature-icon green">✅</div>
        <div class="landing-feature-title">Audit Kualitas (QC)</div>
        <div class="landing-feature-desc">Sistem evaluasi dan rekap kelayakan lapangan secara berkala dengan tim QC untuk memastikan standar kualitas terpenuhi.</div>
      </div>
    </div>
    <div class="landing-footer">© 2026 SportSpace &middot; Platform Manajemen Lapangan Olahraga &middot; Dibuat dengan ❤️ untuk Indonesia</div>
  </div>

  <!-- △△△ LOGIN PAGE △△△ -->
  <div class="login-wrap" x-show="!isAuth && !showLanding" x-transition>
    <div class="login-bg-orb" style="width:400px;height:400px;background:#6366f1;top:-100px;left:-100px;"></div>
    <div class="login-bg-orb" style="width:300px;height:300px;background:#06b6d4;bottom:-80px;right:-60px;"></div>
    <div class="login-bg-orb" style="width:200px;height:200px;background:#8b5cf6;top:40%;right:15%;"></div>
    <div class="login-card">
      <div class="login-logo">
        <div class="login-logo-icon">
          <svg width="32" height="32" viewBox="0 0 24 24" fill="white"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
        </div>
        <div class="login-title">SportSpace</div>
        <div class="login-sub">Sistem Manajemen Sewa Lapangan Olahraga</div>
      </div>
      <div class="login-error" x-show="loginError" x-text="loginError" x-transition></div>
      <form @submit.prevent="doLogin">
        <div class="form-field">
          <label class="form-label">Username</label>
          <input class="form-input" type="text" placeholder="Masukkan username" x-model="loginForm.username" required>
        </div>
        <div class="form-field">
          <label class="form-label">Password</label>
          <input class="form-input" type="password" placeholder="Masukkan password" x-model="loginForm.password" required>
        </div>
        <button type="submit" class="btn-login" :disabled="loginLoading">
          <span x-show="!loginLoading">Masuk ke Dashboard</span>
          <span x-show="loginLoading">Memverifikasi...</span>
        </button>
      </form>
      <p style="text-align:center;margin-top:16px;">
        <button style="background:none;border:none;color:rgba(255,255,255,.45);cursor:pointer;font-size:12px;font-family:inherit;text-decoration:underline;" @click="showLanding=true">← Kembali ke Beranda</button>
      </p>
      <p style="text-align:center;margin-top:8px;font-size:12px;color:rgba(255,255,255,.3);">© 2026 SportSpace &middot; Sistem Manajemen Lapangan</p>
    </div>
  </div>

  <!-- ▓▓▓ MAIN APP ▓▓▓ -->
  <div class="app-wrap" x-show="isAuth" x-transition>

    <!-- ── Sidebar ── -->
    <aside class="sidebar" :class="{'collapsed': sidebarCollapsed}">
      <div class="sb-header">
        <div class="sb-logo">
          <svg viewBox="0 0 24 24" fill="white" width="22" height="22"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
        </div>
        <div class="sb-brand" x-show="!sidebarCollapsed">
          <div class="sb-brand-name">SportSpace</div>
          <div class="sb-brand-sub">Admin Panel</div>
        </div>
      </div>

      <nav class="sb-nav">
        <!-- Beranda -->
        <div class="sb-section">
          <div class="sb-section-label" x-show="!sidebarCollapsed">BERANDA</div>
          <div class="sb-item" :class="{active: page==='dashboard'}" @click="switchPage('dashboard')">
            <svg class="sb-item-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
            <span class="sb-item-label" x-show="!sidebarCollapsed">Dashboard</span>
          </div>
          <div class="sb-item" :class="{active: page==='beranda'}" @click="switchPage('beranda')">
            <svg class="sb-item-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/></svg>
            <span class="sb-item-label" x-show="!sidebarCollapsed">Sewa Lapangan</span>
          </div>
          <div class="sb-item" :class="{active: page==='alamat'}" @click="switchPage('alamat')">
            <svg class="sb-item-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg>
            <span class="sb-item-label" x-show="!sidebarCollapsed">Alamat</span>
          </div>
          <div class="sb-item" :class="{active: page==='about'}" @click="switchPage('about')">
            <svg class="sb-item-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 16v-4M12 8h.01"/></svg>
            <span class="sb-item-label" x-show="!sidebarCollapsed">About Us</span>
          </div>
        </div>

        <!-- Operasional -->
        <div class="sb-section">
          <div class="sb-section-label" x-show="!sidebarCollapsed">MANAJEMEN DATA</div>
          <div class="sb-item" :class="{active: page==='musim'}" @click="switchPage('musim')">
            <svg class="sb-item-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
            <span class="sb-item-label" x-show="!sidebarCollapsed">Musim Operasional</span>
          </div>
          <div class="sb-item" :class="{active: page==='mitra'}" @click="switchPage('mitra')">
            <svg class="sb-item-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/></svg>
            <span class="sb-item-label" x-show="!sidebarCollapsed">Mitra Wilayah</span>
          </div>
          <div class="sb-item" :class="{active: page==='hub'}" @click="switchPage('hub')">
            <svg class="sb-item-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"/><path d="M12 1v4M12 19v4M4.22 4.22l2.83 2.83M16.95 16.95l2.83 2.83M1 12h4M19 12h4M4.22 19.78l2.83-2.83M16.95 7.05l2.83-2.83"/></svg>
            <span class="sb-item-label" x-show="!sidebarCollapsed">Hub Pusat</span>
          </div>
          <div class="sb-item" :class="{active: page==='lapangan'}" @click="switchPage('lapangan')">
            <svg class="sb-item-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M12 7V3M8 3h8M12 21v-4M12 7v4"/></svg>
            <span class="sb-item-label" x-show="!sidebarCollapsed">Data Lapangan</span>
          </div>
          <div class="sb-item" :class="{active: page==='sarana'}" @click="switchPage('sarana')">
            <svg class="sb-item-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 16V8a2 2 0 00-1-1.73l-7-4a2 2 0 00-2 0l-7 4A2 2 0 003 8v8a2 2 0 001 1.73l7 4a2 2 0 002 0l7-4A2 2 0 0021 16z"/></svg>
            <span class="sb-item-label" x-show="!sidebarCollapsed">Sarana Fasilitas</span>
          </div>
        </div>

        <!-- Dokumen & Tarif -->
        <div class="sb-section">
          <div class="sb-section-label" x-show="!sidebarCollapsed">DOKUMEN & TARIF</div>
          <div class="sb-item" :class="{active: page==='dokumen'}" @click="switchPage('dokumen')">
            <svg class="sb-item-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
            <span class="sb-item-label" x-show="!sidebarCollapsed">Dokumen Operasional</span>
          </div>
          <div class="sb-item" :class="{active: page==='tarif'}" @click="switchPage('tarif')">
            <svg class="sb-item-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6"/></svg>
            <span class="sb-item-label" x-show="!sidebarCollapsed">Tarif & Standar</span>
          </div>
        </div>

        <!-- Slot & Target -->
        <div class="sb-section">
          <div class="sb-section-label" x-show="!sidebarCollapsed">SLOT & TARGET</div>
          <div class="sb-item" :class="{active: page==='slot'}" @click="switchPage('slot')">
            <svg class="sb-item-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            <span class="sb-item-label" x-show="!sidebarCollapsed">Slot Waktu</span>
          </div>
          <div class="sb-item" :class="{active: page==='target'}" @click="switchPage('target')">
            <svg class="sb-item-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg>
            <span class="sb-item-label" x-show="!sidebarCollapsed">Target Keterisian</span>
          </div>
        </div>

        <!-- QC -->
        <div class="sb-section">
          <div class="sb-section-label" x-show="!sidebarCollapsed">AUDIT QC</div>
          <div class="sb-item" :class="{active: page==='staf-qc'}" @click="switchPage('staf-qc')">
            <svg class="sb-item-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            <span class="sb-item-label" x-show="!sidebarCollapsed">Staf QC</span>
          </div>
          <div class="sb-item" :class="{active: page==='temuan'}" @click="switchPage('temuan')">
            <svg class="sb-item-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
            <span class="sb-item-label" x-show="!sidebarCollapsed">Kategori Temuan</span>
          </div>
          <div class="sb-item" :class="{active: page==='rekap'}" @click="switchPage('rekap')">
            <svg class="sb-item-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
            <span class="sb-item-label" x-show="!sidebarCollapsed">Rekap Kelayakan</span>
          </div>
        </div>

        <!-- Users -->
        <div class="sb-section">
          <div class="sb-section-label" x-show="!sidebarCollapsed">MANAJEMEN USER</div>
          <div class="sb-item" :class="{active: page==='users-member'}" @click="switchPage('users-member')">
            <svg class="sb-item-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/></svg>
            <span class="sb-item-label" x-show="!sidebarCollapsed">Data Pengguna Portal</span>
          </div>
          <div class="sb-item" :class="{active: page==='users-staff'}" @click="switchPage('users-staff')">
            <svg class="sb-item-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 21V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v16"/></svg>
            <span class="sb-item-label" x-show="!sidebarCollapsed">Pengguna Backoffice</span>
          </div>
        </div>
      </nav>

      <div class="sb-footer">
        <div class="user-pill" @click="doLogout">
          <div class="user-avatar" x-text="currentUser ? currentUser.name.charAt(0).toUpperCase() : 'A'"></div>
          <div class="user-info" x-show="!sidebarCollapsed">
            <div class="user-name" x-text="currentUser ? currentUser.name : 'Admin'"></div>
            <div class="user-role" x-text="currentUser && currentUser.role ? currentUser.role.display_name : 'Administrator'"></div>
          </div>
        </div>
      </div>
    </aside>

    <!-- ── Main Wrapper ── -->
    <div class="main-wrap">
      <!-- Top Bar -->
      <div class="topbar">
        <button class="topbar-toggle" @click="sidebarCollapsed = !sidebarCollapsed">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
        </button>
        <span class="topbar-title" x-text="pageTitle"></span>
        <div class="topbar-right">
          <div class="topbar-btn" title="Notifikasi">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9M13.73 21a2 2 0 01-3.46 0"/></svg>
          </div>
          <div class="topbar-btn" title="Keluar" @click="doLogout" style="color:#ef4444;">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
          </div>
        </div>
      </div>

      <!-- Page Content -->
      <div class="page-content">

        <!-- ══ DASHBOARD ══ -->
        <div x-show="page==='dashboard'">
          <div class="breadcrumb"><span>Dashboard</span></div>

          <!-- Stat Widgets -->
          <div class="stats-grid">
            <div class="stat-card blue">
              <div class="stat-icon blue">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/></svg>
              </div>
              <div class="stat-value" x-text="dashStats.jumlah_penyewa ?? '—'"></div>
              <div class="stat-label">Jumlah Penyewa</div>
              <span class="stat-change up">↑ Aktif</span>
            </div>
            <div class="stat-card teal">
              <div class="stat-icon teal">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/></svg>
              </div>
              <div class="stat-value" x-text="dashStats.jumlah_mitra ?? '—'"></div>
              <div class="stat-label">Mitra / Cabang</div>
              <span class="stat-change up">↑ Jaringan</span>
            </div>
            <div class="stat-card green">
              <div class="stat-icon green">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 21V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v16"/></svg>
              </div>
              <div class="stat-value" x-text="dashStats.jumlah_kategori ?? '—'"></div>
              <div class="stat-label">Kategori Lapangan</div>
              <span class="stat-change up">↑ Jenis Olahraga</span>
            </div>
          </div>

          <!-- Filters -->
          <div class="filter-bar">
            <div class="filter-group">
              <label class="filter-label">Cabang</label>
              <select class="filter-select" x-model="dashFilter.cabang_id" @change="loadDashboard">
                <option value="">Semua Cabang</option>
                <template x-for="c in lookups.cabang" :key="c.id">
                  <option :value="c.id" x-text="c.nama_cabang"></option>
                </template>
              </select>
            </div>
            <div class="filter-group">
              <label class="filter-label">Tahun</label>
              <select class="filter-select" x-model="dashFilter.tahun" @change="loadDashboard">
                <option value="">Semua Tahun</option>
                <option value="2026">2026</option>
                <option value="2025">2025</option>
                <option value="2024">2024</option>
              </select>
            </div>
            <div class="filter-group">
              <label class="filter-label">Jenis Olahraga</label>
              <select class="filter-select" x-model="dashFilter.kategori_id" @change="loadDashboard">
                <option value="">Semua Jenis</option>
                <template x-for="k in lookups.kategori" :key="k.id">
                  <option :value="k.id" x-text="k.nama_kategori"></option>
                </template>
              </select>
            </div>
            <div style="margin-left:auto">
              <button class="btn btn-outline btn-sm" @click="loadDashboard">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="23 4 23 10 17 10"/><path d="M20.49 15a9 9 0 11-2.12-9.36L23 10"/></svg>
                Refresh
              </button>
            </div>
          </div>

          <!-- Chart -->
          <div class="card">
            <div class="card-header">
              <div class="card-title">📊 Grafik Okupansi Keterisian Slot Lapangan</div>
              <button class="btn btn-sm btn-outline" @click="downloadChart">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                  <polyline points="7 10 12 15 17 10"></polyline>
                  <line x1="12" y1="15" x2="12" y2="3"></line>
                </svg>
                Download
              </button>
            </div>
            <div class="card-body">
              <div class="chart-area">
                <canvas id="occupancyChart"></canvas>
              </div>
            </div>
          </div>
        </div>

        <!-- ══ BERANDA / SEWA LAPANGAN (Customer View) ══ -->
        <div x-show="page==='beranda'">
          <div class="customer-header">
            <div class="customer-header-title">🏙️ Temukan & Sewa Lapangan</div>
            <div class="customer-header-sub">Pilih lapangan olahraga terbaik sesuai kebutuhan Anda. Tersedia berbagai jenis lapangan di seluruh Indonesia.</div>
          </div>

          <!-- Filter Bar -->
          <div class="sewa-filter-bar">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color:var(--text-muted)"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
            <input class="field-input" style="flex:1;max-width:280px" placeholder="Cari nama lapangan..." x-model="sewaSearch">
            <select class="field-select" style="max-width:180px" x-model="sewaFilterCabang">
              <option value="">Semua Cabang</option>
              <template x-for="c in lookups.cabang" :key="c.id">
                <option :value="c.id" x-text="c.nama_cabang"></option>
              </template>
            </select>
            <select class="field-select" style="max-width:180px" x-model="sewaFilterKategori">
              <option value="">Semua Jenis</option>
              <template x-for="k in lookups.kategori" :key="k.id">
                <option :value="k.id" x-text="k.nama_kategori"></option>
              </template>
            </select>
            <span style="font-size:13px;color:var(--text-muted);margin-left:auto" x-text="getFilteredLapangan().length + ' lapangan ditemukan'"></span>
          </div>

          <!-- Card Grid -->
          <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(300px,1fr));gap:24px">
            <template x-for="l in getFilteredLapangan()" :key="l.id">
              <div class="sewa-card">
                <!-- Image -->
                <div class="sewa-card-img" style="position:relative">
                  <template x-if="l.foto">
                    <img :src="l.foto" style="width:100%;height:200px;object-fit:cover" alt="Foto Lapangan">
                  </template>
                  <template x-if="!l.foto">
                    <div style="width:100%;height:200px;background:linear-gradient(135deg,#e0e7ff,#c7d2fe);display:flex;align-items:center;justify-content:center;font-size:48px">
                      <template x-if="l.kategori_lapangan && l.kategori_lapangan.nama_kategori.toLowerCase()==='futsal'"><span>⚽</span></template>
                      <template x-if="l.kategori_lapangan && l.kategori_lapangan.nama_kategori.toLowerCase()==='badminton'"><span>🌸</span></template>
                      <template x-if="!l.kategori_lapangan || (l.kategori_lapangan.nama_kategori.toLowerCase()!=='futsal' && l.kategori_lapangan.nama_kategori.toLowerCase()!=='badminton')"><span>🏠</span></template>
                    </div>
                  </template>
                  <!-- Status Badge -->
                  <div class="sewa-card-status" :class="l.is_active ? 'available':'busy'" x-text="l.is_active ? 'Tersedia':'Tidak Aktif'"></div>
                  <!-- Sport Badge -->
                  <div class="sewa-card-sport-badge">
                    <template x-if="l.kategori_lapangan && l.kategori_lapangan.nama_kategori.toLowerCase()==='futsal'"><span>⚽</span></template>
                    <template x-if="l.kategori_lapangan && l.kategori_lapangan.nama_kategori.toLowerCase()==='badminton'"><span>🌸</span></template>
                    <template x-if="!l.kategori_lapangan || (l.kategori_lapangan.nama_kategori.toLowerCase()!=='futsal' && l.kategori_lapangan.nama_kategori.toLowerCase()!=='badminton')"><span>🏡</span></template>
                  </div>
                </div>
                <!-- Body -->
                <div class="sewa-card-body">
                  <div class="sewa-card-venue" x-text="(l.cabang ? l.cabang.nama_cabang : 'Cabang') + ' • ' + l.kode"></div>
                  <div class="sewa-card-name" x-text="l.nama_lapangan"></div>
                  <div class="sewa-card-info">
                    <div class="sewa-card-info-row">
                      <span class="sewa-card-info-icon">📍</span>
                      <span x-text="l.cabang ? l.cabang.alamat || l.cabang.nama_cabang : 'Lokasi belum diatur'"></span>
                    </div>
                    <div class="sewa-card-info-row">
                      <span class="sewa-card-info-icon">🎾</span>
                      <span x-text="l.kategori_lapangan ? l.kategori_lapangan.nama_kategori : 'Olahraga Umum'"></span>
                    </div>
                    <div class="sewa-card-info-row">
                      <span class="sewa-card-info-icon">🏆</span>
                      <span>Akreditasi <span class="sewa-card-akreditasi" :class="l.akreditasi" x-text="l.akreditasi"></span></span>
                    </div>
                  </div>
                  <div class="sewa-card-divider"></div>
                  <div class="sewa-card-price">
                    <span class="sewa-card-price-from">Mulai dari</span>
                    <span class="sewa-card-price-val" x-text="(() => { const ts = tarifList.filter(t => t.cabang_id === l.cabang_id); return ts.length > 0 ? 'Rp' + Math.min(...ts.map(t => parseFloat(t.nilai_tarif))).toLocaleString('id-ID') : 'Rp 100.000'; })()"></span>
                    <span class="sewa-card-price-unit">/ sesi</span>
                  </div>
                  <div class="sewa-card-footer">
                    <button class="sewa-btn-book" @click="toast('info', 'Fitur pemesanan akan segera tersedia!')">Pesan Sekarang</button>
                    <button class="sewa-btn-detail" @click="toast('info', 'SK: ' + (l.nomor_sk || '-'))">Detail</button>
                  </div>
                </div>
              </div>
            </template>
          </div>

          <div x-show="getFilteredLapangan().length===0" class="empty-state">
            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 21V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v16"/></svg>
            <p>Tidak ada lapangan yang cocok dengan filter</p>
          </div>
        </div>

        <!-- ══ ALAMAT ══ -->
        <div x-show="page==='alamat'">
          <div class="breadcrumb"><span>Alamat Cabang</span></div>
          <div class="card">
            <div class="card-header"><div class="card-title">📍 Lokasi Cabang</div></div>
            <div class="card-body">
              <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(300px,1fr));gap:16px">
                <template x-for="c in lookups.cabang" :key="c.id">
                  <div style="border:1px solid var(--border);border-radius:12px;padding:20px">
                    <div style="font-weight:700;font-size:15px;margin-bottom:8px" x-text="c.nama_cabang"></div>
                    <div style="font-size:13px;color:var(--text-muted);margin-bottom:4px">📍 <span x-text="c.alamat || '—'"></span></div>
                    <div style="font-size:13px;color:var(--text-muted)">📞 <span x-text="c.telepon || '—'"></span></div>
                    <div style="margin-top:10px"><span class="badge" :class="c.is_active ? 'badge-success':'badge-danger'" x-text="c.is_active ? 'Aktif':'Tidak Aktif'"></span></div>
                  </div>
                </template>
              </div>
            </div>
          </div>
        </div>

        <!-- ══ ABOUT ══ -->
        <div x-show="page==='about'">
          <div class="breadcrumb"><span>About Us</span></div>
          <div class="card">
            <div class="card-body" style="text-align:center;padding:60px 40px">
              <div style="width:80px;height:80px;border-radius:20px;background:linear-gradient(135deg,#6366f1,#06b6d4);display:flex;align-items:center;justify-content:center;margin:0 auto 24px">
                <svg width="40" height="40" viewBox="0 0 24 24" fill="white"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
              </div>
              <h1 style="font-size:28px;font-weight:800;margin-bottom:12px">SportSpace</h1>
              <p style="color:var(--text-muted);max-width:500px;margin:0 auto;line-height:1.7">Platform manajemen sewa lapangan olahraga terpadu. Kami menyediakan solusi digital untuk pengelolaan lapangan badminton, futsal, dan berbagai olahraga lainnya secara profesional.</p>
              <div style="display:flex;justify-content:center;gap:24px;margin-top:32px;flex-wrap:wrap">
                <div style="text-align:center"><div style="font-size:28px;font-weight:800;color:var(--primary)">500+</div><div style="color:var(--text-muted);font-size:13px">Lapangan Terkelola</div></div>
                <div style="text-align:center"><div style="font-size:28px;font-weight:800;color:var(--accent)">50+</div><div style="color:var(--text-muted);font-size:13px">Kota di Indonesia</div></div>
                <div style="text-align:center"><div style="font-size:28px;font-weight:800;color:var(--success)">10K+</div><div style="color:var(--text-muted);font-size:13px">Penyewa Aktif</div></div>
              </div>
            </div>
          </div>
        </div>

        <!-- ══ MUSIM OPERASIONAL ══ -->
        <div x-show="page==='musim'">
          <div class="breadcrumb"><span>Musim / Tahun Operasional</span></div>
          <div class="card">
            <div class="card-header">
              <div class="card-title">📅 Daftar Musim Operasional</div>
              <button class="btn btn-primary btn-sm" @click="openModal('musim-add')">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Tambah Musim
              </button>
            </div>
            <div class="table-wrap">
              <table>
                <thead><tr>
                  <th>No</th>
                  <th>Tahun</th>
                  <th>Status</th>
                  <th>Aksi</th>
                </tr></thead>
                <tbody>
                  <template x-for="(m, i) in musimList" :key="m.id">
                    <tr>
                      <td x-text="i+1"></td>
                      <td><strong x-text="m.tahun"></strong></td>
                      <td>
                        <span class="badge" :class="m.status==='Aktif' ? 'badge-success':'badge-warning'" x-text="m.status"></span>
                      </td>
                      <td>
                        <div class="action-btns">
                          <button class="btn-icon edit" title="Edit" @click="editMusim(m)">✏️</button>
                          <button class="btn-icon delete" title="Hapus" :disabled="m.status==='Aktif'" :style="m.status==='Aktif' ? 'opacity:.35;cursor:not-allowed':''" @click="m.status!=='Aktif' && deleteMusim(m.id)" :title="m.status==='Aktif'?'Tidak dapat dihapus saat Aktif':'Hapus'">🗑️</button>
                        </div>
                      </td>
                    </tr>
                  </template>
                  <tr x-show="musimList.length===0"><td colspan="4" class="empty-state"><p>Belum ada data musim operasional</p></td></tr>
                </tbody>
              </table>
            </div>
          </div>

          <!-- Modal Tambah/Edit Musim -->
          <div class="modal-overlay" x-show="modal==='musim-add' || modal==='musim-edit'" @click.self="modal=''">
            <div class="modal">
              <div class="modal-header">
                <div class="modal-title" x-text="modal==='musim-add' ? 'Tambah Musim Operasional' : 'Edit Musim Operasional'"></div>
                <button class="modal-close" @click="modal=''">✕</button>
              </div>
              <div class="modal-body">
                <div class="field-group">
                  <label class="field-label">Tahun *</label>
                  <input class="field-input" type="number" min="2000" max="2100" x-model="form.tahun" placeholder="Contoh: 2026">
                </div>
                <div class="field-group">
                  <label class="field-label">Status *</label>
                  <select class="field-select" x-model="form.status">
                    <option value="Aktif">Aktif</option>
                    <option value="Tidak Aktif">Tidak Aktif</option>
                  </select>
                </div>
              </div>
              <div class="modal-footer">
                <button class="btn btn-secondary" @click="modal=''">Batal</button>
                <button class="btn btn-primary" @click="saveMusim">Simpan</button>
              </div>
            </div>
          </div>
        </div>

        <!-- ══ MITRA WILAYAH ══ -->
        <div x-show="page==='mitra'">
          <div class="breadcrumb"><span>Mitra Wilayah</span></div>
          <div class="card">
            <div class="card-header">
              <div class="card-title">🤝 Daftar Mitra / Cabang</div>
              <button class="btn btn-primary btn-sm" @click="openModal('mitra-add')">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Tambah Mitra
              </button>
            </div>
            <div class="table-wrap">
              <table>
                <thead><tr><th>No</th><th>Nama Cabang / Mitra</th><th>Keterangan</th><th>Alamat</th><th>Telp</th><th>Aksi</th></tr></thead>
                <tbody>
                  <template x-for="(m,i) in mitraList" :key="m.id">
                    <tr>
                      <td x-text="i+1"></td>
                      <td><strong x-text="m.nama_cabang"></strong></td>
                      <td x-text="m.keterangan||'—'"></td>
                      <td x-text="m.alamat||'—'"></td>
                      <td x-text="m.telepon||'—'"></td>
                      <td><div class="action-btns">
                        <button class="btn-icon edit" @click="editMitra(m)">✏️</button>
                        <button class="btn-icon delete" @click="deleteMitra(m.id)">🗑️</button>
                      </div></td>
                    </tr>
                  </template>
                  <tr x-show="mitraList.length===0"><td colspan="6" class="empty-state"><p>Belum ada data mitra</p></td></tr>
                </tbody>
              </table>
            </div>
          </div>

          <div class="modal-overlay" x-show="modal==='mitra-add'||modal==='mitra-edit'" @click.self="modal=''">
            <div class="modal">
              <div class="modal-header">
                <div class="modal-title" x-text="modal==='mitra-add'?'Tambah Mitra':'Edit Mitra'"></div>
                <button class="modal-close" @click="modal=''">✕</button>
              </div>
              <div class="modal-body">
                <div class="field-group"><label class="field-label">Nama Cabang / Mitra *</label><input class="field-input" x-model="form.nama_cabang" placeholder="Nama cabang"></div>
                <div class="field-group"><label class="field-label">Keterangan</label><textarea class="field-textarea" x-model="form.keterangan" placeholder="Keterangan singkat..."></textarea></div>
                <div class="form-row">
                  <div class="field-group"><label class="field-label">Alamat</label><input class="field-input" x-model="form.alamat" placeholder="Alamat lengkap"></div>
                  <div class="field-group"><label class="field-label">Telepon</label><input class="field-input" x-model="form.telepon" placeholder="021-xxxxxxx"></div>
                </div>
              </div>
              <div class="modal-footer">
                <button class="btn btn-secondary" @click="modal=''">Batal</button>
                <button class="btn btn-primary" @click="saveMitra">Simpan</button>
              </div>
            </div>
          </div>
        </div>

        <!-- ══ HUB PUSAT ══ -->
        <div x-show="page==='hub'">
          <div class="breadcrumb"><span>Hub Pusat</span></div>
          <div class="card">
            <div class="card-header">
              <div class="card-title">🌐 Manajemen Hub Induk Olahraga</div>
              <button class="btn btn-primary btn-sm" @click="openModal('hub-add')">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Tambah Hub
              </button>
            </div>
            <div class="table-wrap">
              <table>
                <thead><tr><th>No</th><th>Nama Hub</th><th>Deskripsi</th><th>Aksi</th></tr></thead>
                <tbody>
                  <template x-for="(h,i) in hubList" :key="h.id">
                    <tr>
                      <td x-text="i+1"></td>
                      <td><strong x-text="h.nama_hub"></strong></td>
                      <td x-text="h.deskripsi||'—'"></td>
                      <td><div class="action-btns">
                        <button class="btn-icon edit" @click="editHub(h)">✏️</button>
                        <button class="btn-icon delete" @click="deleteHub(h.id)">🗑️</button>
                      </div></td>
                    </tr>
                  </template>
                  <tr x-show="hubList.length===0"><td colspan="4" class="empty-state"><p>Belum ada data hub</p></td></tr>
                </tbody>
              </table>
            </div>
          </div>

          <div class="modal-overlay" x-show="modal==='hub-add'||modal==='hub-edit'" @click.self="modal=''">
            <div class="modal">
              <div class="modal-header">
                <div class="modal-title" x-text="modal==='hub-add'?'Tambah Hub Pusat':'Edit Hub Pusat'"></div>
                <button class="modal-close" @click="modal=''">✕</button>
              </div>
              <div class="modal-body">
                <div class="field-group"><label class="field-label">Nama Hub *</label><input class="field-input" x-model="form.nama_hub" placeholder="Nama hub pusat olahraga"></div>
                <div class="field-group"><label class="field-label">Deskripsi</label><textarea class="field-textarea" x-model="form.deskripsi" placeholder="Deskripsi hub"></textarea></div>
              </div>
              <div class="modal-footer">
                <button class="btn btn-secondary" @click="modal=''">Batal</button>
                <button class="btn btn-primary" @click="saveHub">Simpan</button>
              </div>
            </div>
          </div>
        </div>

        <!-- ══ DATA LAPANGAN (Admin Table View) ══ -->
        <div x-show="page==='lapangan'">
          <div class="breadcrumb"><span>Data Lapangan</span></div>

          <div class="card">
            <!-- Admin Header -->
            <div style="padding:24px 24px 0">
              <div class="admin-lapangan-header">
                <div class="admin-lapangan-header-left">
                  <h2>Data Master Lapangan</h2>
                  <p>Kelola data lapangan, akreditasi, legalitas dan foto dokumentasi</p>
                </div>
                <div class="admin-search-group">
                  <input class="field-input" style="width:220px" placeholder="🔍 Cari lapangan..." x-model="lapanganSearch">
                  <button class="btn btn-primary" @click="openModal('lap-add')">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                    Tambah Lapangan
                  </button>
                </div>
              </div>
            </div>

            <!-- Table -->
            <div class="table-wrap">
              <table>
                <thead>
                  <tr>
                    <th style="width:50px">No</th>
                    <th style="width:70px">Foto</th>
                    <th>Kode</th>
                    <th>Nama Lapangan</th>
                    <th>Kategori</th>
                    <th>Cabang</th>
                    <th>Akreditasi</th>
                    <th>Status</th>
                    <th style="width:100px">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <template x-for="(l, i) in getFilteredAdminLapangan()" :key="l.id">
                    <tr>
                      <td x-text="i+1" style="font-weight:600;color:var(--text-muted)"></td>
                      <td>
                        <template x-if="l.foto">
                          <img :src="l.foto" class="lapangan-table-thumb" alt="foto">
                        </template>
                        <template x-if="!l.foto">
                          <div class="lapangan-table-thumb-placeholder">
                            <template x-if="l.kategori_lapangan && l.kategori_lapangan.nama_kategori.toLowerCase()==='futsal'"><span>⚽</span></template>
                            <template x-if="l.kategori_lapangan && l.kategori_lapangan.nama_kategori.toLowerCase()==='badminton'"><span>🌸</span></template>
                            <template x-if="!l.kategori_lapangan || (l.kategori_lapangan.nama_kategori.toLowerCase()!=='futsal'&&l.kategori_lapangan.nama_kategori.toLowerCase()!=='badminton')"><span>🏠</span></template>
                          </div>
                        </template>
                      </td>
                      <td><code style="background:#f1f5f9;padding:3px 8px;border-radius:6px;font-size:12px;color:var(--primary)" x-text="l.kode"></code></td>
                      <td>
                        <div style="font-weight:700;font-size:14px" x-text="l.nama_lapangan"></div>
                        <div style="font-size:12px;color:var(--text-muted)" x-text="l.nomor_sk ? 'SK: ' + l.nomor_sk : ''"></div>
                      </td>
                      <td>
                        <span style="display:inline-flex;align-items:center;gap:4px;font-size:13px">
                          <template x-if="l.kategori_lapangan && l.kategori_lapangan.nama_kategori.toLowerCase()==='futsal'"><span>⚽</span></template>
                          <template x-if="l.kategori_lapangan && l.kategori_lapangan.nama_kategori.toLowerCase()==='badminton'"><span>🌸</span></template>
                          <template x-if="!l.kategori_lapangan || (l.kategori_lapangan.nama_kategori.toLowerCase()!=='futsal'&&l.kategori_lapangan.nama_kategori.toLowerCase()!=='badminton')"><span>🏠</span></template>
                          <span x-text="l.kategori_lapangan ? l.kategori_lapangan.nama_kategori : '—'"></span>
                        </span>
                      </td>
                      <td>
                        <div style="font-size:13px;font-weight:600" x-text="l.cabang ? l.cabang.nama_cabang : '—'"></div>
                      </td>
                      <td>
                        <span class="badge" :class="l.akreditasi==='A'?'badge-success':l.akreditasi==='Unggul'?'badge-info':l.akreditasi==='B'?'badge-warning':'badge-danger'" x-text="l.akreditasi"></span>
                      </td>
                      <td>
                        <span style="display:flex;align-items:center;font-size:13px">
                          <span class="status-dot" :class="l.is_active ? 'active':'inactive'"></span>
                          <span x-text="l.is_active ? 'Aktif':'Non-aktif'" :style="l.is_active?'color:#15803d':'color:#b91c1c'"></span>
                        </span>
                      </td>
                      <td>
                        <div class="action-btns">
                          <button class="btn-icon edit" @click="editLapangan(l)" title="Edit Data">✏️</button>
                          <button class="btn-icon delete" @click="confirmDeleteLapangan(l)" title="Hapus Data">🗑️</button>
                        </div>
                      </td>
                    </tr>
                  </template>
                  <tr x-show="getFilteredAdminLapangan().length===0">
                    <td colspan="9" class="empty-state"><p>Belum ada data lapangan</p></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <!-- ══ SARANA FASILITAS ══ -->
        <div x-show="page==='sarana'">
          <div class="breadcrumb"><span>Sarana Fasilitas</span></div>
          <div class="card">
            <div class="card-header">
              <div class="card-title">🏗️ Sarana & Fasilitas Tambahan</div>
              <button class="btn btn-primary btn-sm" @click="openModal('sarana-add')">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Tambah Fasilitas
              </button>
            </div>
            <div class="table-wrap">
              <table>
                <thead><tr><th>No</th><th>Kode Fasilitas</th><th>Nama Unit</th><th>Lapangan</th><th>Alamat</th><th>Aksi</th></tr></thead>
                <tbody>
                  <template x-for="(s,i) in saranaList" :key="s.id">
                    <tr>
                      <td x-text="i+1"></td>
                      <td><code style="font-size:12px;background:#f1f5f9;padding:2px 6px;border-radius:4px" x-text="s.kode_fasilitas"></code></td>
                      <td x-text="s.nama_unit"></td>
                      <td x-text="s.lapangan ? s.lapangan.nama_lapangan : '—'"></td>
                      <td x-text="s.alamat||'—'"></td>
                      <td><div class="action-btns">
                        <button class="btn-icon edit" @click="editSarana(s)">✏️</button>
                        <button class="btn-icon delete" @click="deleteSarana(s.id)">🗑️</button>
                      </div></td>
                    </tr>
                  </template>
                  <tr x-show="saranaList.length===0"><td colspan="6" class="empty-state"><p>Belum ada data sarana</p></td></tr>
                </tbody>
              </table>
            </div>
          </div>

          <div class="modal-overlay" x-show="modal==='sarana-add' || modal==='sarana-edit'" @click.self="modal=''">
            <div class="modal">
              <div class="modal-header">
                <div class="modal-title" x-text="editingId ? 'Edit Sarana Fasilitas' : 'Tambah Sarana Fasilitas'"></div>
                <button class="modal-close" @click="modal=''">✕</button>
              </div>
              <div class="modal-body">
                <div class="field-group">
                  <label class="field-label">Lapangan *</label>
                  <select class="field-select" x-model="form.lapangan_id">
                    <option value="">-- Pilih Lapangan --</option>
                    <template x-for="l in lookups.lapangan" :key="l.id"><option :value="l.id" x-text="l.nama_lapangan"></option></template>
                  </select>
                </div>
                <div class="form-row">
                  <div class="field-group"><label class="field-label">Kode Fasilitas *</label><input class="field-input" x-model="form.kode_fasilitas" placeholder="SF-LK-01 (Loker, Kantin, dll)"></div>
                  <div class="field-group"><label class="field-label">Nama Unit *</label><input class="field-input" x-model="form.nama_unit" placeholder="Nama unit fasilitas"></div>
                </div>
                <div class="field-group"><label class="field-label">Alamat</label><input class="field-input" x-model="form.alamat" placeholder="Lokasi fasilitas"></div>
              </div>
              <div class="modal-footer">
                <button class="btn btn-secondary" @click="modal=''">Batal</button>
                <button class="btn btn-primary" @click="saveSarana">Simpan</button>
              </div>
            </div>
          </div>
        </div>

        <!-- ══ DOKUMEN OPERASIONAL ══ -->
        <div x-show="page==='dokumen'">
          <div class="breadcrumb"><span>Manajemen Dokumen Operasional</span></div>

          <!-- Filter Bar -->
          <div class="filter-bar">
            <div class="filter-group">
              <label class="filter-label">Kategori Dokumen</label>
              <select class="filter-select" x-model="dokumenFilter.kategori" @change="loadDokumen">
                <option value="">Semua Kategori</option>
                <option>Kebijakan</option><option>Manual</option><option>Legalitas</option><option>Sistem Informasi</option>
              </select>
            </div>
            <div class="filter-group">
              <label class="filter-label">Unit Pengunggah</label>
              <select class="filter-select" x-model="dokumenFilter.unit_pengunggah" @change="loadDokumen">
                <option value="">Semua Unit</option>
                <option>Cabang</option><option>Fakultas</option><option>Pusat</option>
              </select>
            </div>
            <div class="filter-group">
              <label class="filter-label">Jabatan Pengunggah</label>
              <input class="filter-input" type="text" placeholder="Cari jabatan..." x-model="dokumenFilter.jabatan_pengunggah" @input.debounce.400="loadDokumen">
            </div>
            <div style="margin-left:auto">
              <button class="btn btn-primary btn-sm" @click="openModal('dok-add')">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Upload Dokumen
              </button>
            </div>
          </div>

          <div class="card">
            <div class="table-wrap">
              <table>
                <thead><tr>
                  <th @click="sortDokumen('id')">No <span class="sort-icon">⇅</span></th>
                  <th>Aksi</th>
                  <th @click="sortDokumen('nama_dokumen')">Nama Dokumen <span class="sort-icon">⇅</span></th>
                  <th @click="sortDokumen('tahun')">Tahun <span class="sort-icon">⇅</span></th>
                  <th @click="sortDokumen('kategori')">Kategori <span class="sort-icon">⇅</span></th>
                  <th>Jenis</th>
                  <th @click="sortDokumen('unit_pengunggah')">Unit <span class="sort-icon">⇅</span></th>
                  <th>User/Jabatan</th>
                </tr></thead>
                <tbody>
                  <template x-for="(d,i) in dokumenList" :key="d.id">
                    <tr>
                      <td x-text="i+1"></td>
                      <td><div class="action-btns">
                        <a :href="d.file_path" target="_blank" class="btn-icon blue" title="Lihat">👁</a>
                        <button class="btn-icon delete" @click="deleteDokumen(d.id)">🗑️</button>
                      </div></td>
                      <td><strong x-text="d.nama_dokumen"></strong></td>
                      <td x-text="d.tahun"></td>
                      <td><span class="badge badge-info" x-text="d.kategori"></span></td>
                      <td>PDF</td>
                      <td x-text="d.unit_pengunggah"></td>
                      <td x-text="d.jabatan_pengunggah"></td>
                    </tr>
                  </template>
                  <tr x-show="dokumenList.length===0"><td colspan="8" class="empty-state"><p>Belum ada dokumen</p></td></tr>
                </tbody>
              </table>
            </div>
          </div>

          <div class="modal-overlay" x-show="modal==='dok-add'" @click.self="modal=''">
            <div class="modal">
              <div class="modal-header"><div class="modal-title">Upload Dokumen Operasional</div><button class="modal-close" @click="modal=''">✕</button></div>
              <div class="modal-body">
                <div class="field-group"><label class="field-label">Nama Dokumen *</label><input class="field-input" x-model="form.nama_dokumen" placeholder="Nama lengkap dokumen"></div>
                <div class="form-row">
                  <div class="field-group"><label class="field-label">Tahun *</label><input class="field-input" type="number" x-model="form.tahun" placeholder="2026"></div>
                  <div class="field-group">
                    <label class="field-label">Kategori *</label>
                    <select class="field-select" x-model="form.kategori">
                      <option value="">-- Pilih --</option>
                      <option>Kebijakan</option><option>Manual</option><option>Legalitas</option><option>Sistem Informasi</option>
                    </select>
                  </div>
                </div>
                <div class="form-row">
                  <div class="field-group">
                    <label class="field-label">Unit Pengunggah *</label>
                    <select class="field-select" x-model="form.unit_pengunggah">
                      <option value="">-- Pilih Unit --</option>
                      <option>Cabang</option><option>Fakultas</option><option>Pusat</option>
                    </select>
                  </div>
                  <div class="field-group"><label class="field-label">Jabatan Pengunggah *</label><input class="field-input" x-model="form.jabatan_pengunggah" placeholder="Contoh: Kepala Cabang"></div>
                </div>
                <div class="field-group">
                  <label class="field-label">File Dokumen (PDF, maks 7MB) *</label>
                  <input class="field-file" type="file" accept=".pdf" @change="form.file_dokumen = $event.target.files[0]">
                  <div class="field-hint">Hanya file PDF, maksimal 7MB</div>
                </div>
              </div>
              <div class="modal-footer">
                <button class="btn btn-secondary" @click="modal=''">Batal</button>
                <button class="btn btn-primary" @click="saveDokumen">Upload & Simpan</button>
              </div>
            </div>
          </div>
        </div>

        <!-- ══ TARIF & STANDAR ══ -->
        <div x-show="page==='tarif'">
          <div class="breadcrumb"><span>Tarif & Standar Fasilitas</span></div>
          <div class="page-tabs">
            <button class="page-tab" :class="{active: tarifTab==='skema'}" @click="tarifTab='skema'">💰 Skema Tarif</button>
            <button class="page-tab" :class="{active: tarifTab==='standar'}" @click="tarifTab='standar'">📋 Standar Fasilitas</button>
          </div>

          <!-- Skema Tarif -->
          <div x-show="tarifTab==='skema'">
            <div class="filter-bar">
              <div class="filter-group">
                <label class="filter-label">Tahun</label>
                <select class="filter-select" x-model="tarifFilter.tahun" @change="loadTarif">
                  <option value="">Semua Tahun</option>
                  <option>2026</option><option>2025</option><option>2024</option>
                </select>
              </div>
              <div class="filter-group">
                <label class="filter-label">Cabang</label>
                <select class="filter-select" x-model="tarifFilter.cabang_id" @change="loadTarif">
                  <option value="">Semua Cabang</option>
                  <template x-for="c in lookups.cabang" :key="c.id"><option :value="c.id" x-text="c.nama_cabang"></option></template>
                </select>
              </div>
              <div style="margin-left:auto">
                <button class="btn btn-primary btn-sm" @click="openModal('tarif-add')">+ Tambah Tarif</button>
              </div>
            </div>
            <div class="card">
              <div class="table-wrap">
                <table>
                  <thead><tr><th>No</th><th>Nilai Tarif (Rp)</th><th>Deskripsi Skema Jam</th><th>Periode</th><th>Lokasi Lapangan</th><th>Cabang</th><th>Aksi</th></tr></thead>
                  <tbody>
                    <template x-for="(t,i) in tarifList" :key="t.id">
                      <tr>
                        <td x-text="i+1"></td>
                        <td><strong x-text="'Rp ' + Number(t.nilai_tarif).toLocaleString('id-ID')"></strong></td>
                        <td><span class="badge" :class="(t.deskripsi_skema_jam && t.deskripsi_skema_jam.includes('Pagi')) ? 'badge-warning' : 'badge-info'" x-text="t.deskripsi_skema_jam || '—'"></span></td>
                        <td x-text="t.periode"></td>
                        <td x-text="t.lokasi_lapangan"></td>
                        <td x-text="t.cabang ? t.cabang.nama_cabang : '—'"></td>
                        <td><button class="btn-icon delete" @click="deleteTarif(t.id)">🗑️</button></td>
                      </tr>
                    </template>
                    <tr x-show="tarifList.length===0"><td colspan="7" class="empty-state"><p>Belum ada skema tarif</p></td></tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>

          <!-- Standar Fasilitas Hierarchical -->
          <div x-show="tarifTab==='standar'">
            <div class="card">
              <div class="card-header">
                <div class="card-title">🏗️ Standar Fasilitas (Hierarchical)</div>
                <div style="display:flex;gap:8px">
                  <button class="btn btn-sm btn-secondary" @click="expandAll=true">Expand All</button>
                  <button class="btn btn-sm btn-secondary" @click="expandAll=false">Collapse All</button>
                  <button class="btn btn-sm btn-primary" @click="openModal('standar-add')">+ Tambah</button>
                </div>
              </div>
              <div class="card-body">
                <template x-for="parent in standarList" :key="parent.id">
                  <div class="tree-parent">
                    <div class="tree-parent-row" @click="parent._open = !parent._open">
                      <div class="tree-toggle" :class="{open: parent._open || expandAll}">
                        <span x-text="(parent._open || expandAll) ? '−' : '+'"></span>
                      </div>
                      <strong style="flex:1" x-text="parent.nama_fasilitas"></strong>
                      <span class="badge badge-purple" x-text="parent.jenis_indikator"></span>
                      <span style="font-size:12px;color:var(--text-muted);margin-left:12px">Bobot: <strong x-text="parent.bobot_kelayakan + '%'"></strong></span>
                      <button class="btn-icon delete" style="margin-left:10px" @click.stop="deleteStandar(parent.id)">🗑️</button>
                    </div>
                    <div class="tree-children" x-show="parent._open || expandAll">
                      <table>
                        <thead><tr><th>#</th><th>Nama Sub-Fasilitas</th><th>Jenis Indikator</th><th>Bobot</th><th>Aksi</th></tr></thead>
                        <tbody>
                          <template x-for="(child,ci) in (parent.children||[])" :key="child.id">
                            <tr>
                              <td x-text="ci+1"></td>
                              <td x-text="child.nama_fasilitas"></td>
                              <td><span class="badge badge-info" x-text="child.jenis_indikator"></span></td>
                              <td x-text="child.bobot_kelayakan + '%'"></td>
                              <td><button class="btn-icon delete" @click="deleteStandar(child.id)">🗑️</button></td>
                            </tr>
                          </template>
                          <tr x-show="!parent.children || parent.children.length===0">
                            <td colspan="5" style="text-align:center;color:var(--text-muted);padding:12px">Tidak ada sub-fasilitas</td>
                          </tr>
                        </tbody>
                      </table>
                      <div style="padding:12px 16px;border-top:1px solid var(--border)">
                        <button class="btn btn-sm btn-outline" @click="openAddChildStandar(parent.id)">+ Tambah Sub-Fasilitas</button>
                      </div>
                    </div>
                  </div>
                </template>
                <div x-show="standarList.length===0" class="empty-state"><p>Belum ada data standar fasilitas</p></div>
              </div>
            </div>
          </div>

          <!-- Modal Tarif -->
          <div class="modal-overlay" x-show="modal==='tarif-add'" @click.self="modal=''">
            <div class="modal">
              <div class="modal-header"><div class="modal-title">Tambah Skema Tarif</div><button class="modal-close" @click="modal=''">✕</button></div>
              <div class="modal-body">
                <div class="form-row">
                  <div class="field-group">
                    <label class="field-label">Cabang *</label>
                    <select class="field-select" x-model="form.cabang_id">
                      <option value="">-- Pilih Cabang --</option>
                      <template x-for="c in lookups.cabang" :key="c.id"><option :value="c.id" x-text="c.nama_cabang"></option></template>
                    </select>
                  </div>
                  <div class="field-group"><label class="field-label">Tahun *</label><input class="field-input" type="number" x-model="form.tahun" placeholder="2026"></div>
                </div>
                <div class="field-group"><label class="field-label">Nilai Tarif (Rp) *</label><input class="field-input" type="number" x-model="form.nilai_tarif" placeholder="150000"></div>
                <div class="field-group">
                  <label class="field-label">Deskripsi Skema Jam *</label>
                  <select class="field-select" x-model="form.deskripsi_skema_jam">
                    <option value="">-- Pilih --</option>
                    <option>Pagi (08:00 - 12:00)</option>
                    <option>Siang (12:00 - 16:00)</option>
                    <option>Malam (16:00 - 22:00)</option>
                  </select>
                </div>
                <div class="form-row">
                  <div class="field-group"><label class="field-label">Periode *</label><input class="field-input" x-model="form.periode" placeholder="Musim Reguler"></div>
                  <div class="field-group"><label class="field-label">Lokasi Lapangan *</label><input class="field-input" x-model="form.lokasi_lapangan" placeholder="Jakarta Selatan"></div>
                </div>
              </div>
              <div class="modal-footer">
                <button class="btn btn-secondary" @click="modal=''">Batal</button>
                <button class="btn btn-primary" @click="saveTarif">Simpan</button>
              </div>
            </div>
          </div>

          <!-- Modal Standar Fasilitas -->
          <div class="modal-overlay" x-show="modal==='standar-add'" @click.self="modal=''">
            <div class="modal modal-lg">
              <div class="modal-header"><div class="modal-title">Tambah Standar Fasilitas</div><button class="modal-close" @click="modal=''">✕</button></div>
              <div class="modal-body">
                <div class="field-group">
                  <label class="field-label">Parent (Kosongkan jika Induk)</label>
                  <select class="field-select" x-model="form.parent_id">
                    <option value="">-- Fasilitas Induk (Parent) --</option>
                    <template x-for="s in standarList" :key="s.id"><option :value="s.id" x-text="s.nama_fasilitas"></option></template>
                  </select>
                </div>
                <div class="field-group"><label class="field-label">Nama Fasilitas *</label><input class="field-input" x-model="form.nama_fasilitas" placeholder="Nama fasilitas"></div>
                <div class="field-group">
                  <label class="field-label">Deskripsi (Rich Text) *</label>
                  <div id="quillEditor" style="border:1.5px solid var(--border);border-radius:9px;overflow:hidden"></div>
                </div>
                <div class="form-row">
                  <div class="field-group">
                    <label class="field-label">Jenis Indikator *</label>
                    <select class="field-select" x-model="form.jenis_indikator">
                      <option value="kuantitatif">Kuantitatif</option>
                      <option value="kualitatif">Kualitatif</option>
                    </select>
                  </div>
                  <div class="field-group"><label class="field-label">Bobot Kelayakan (%) *</label><input class="field-input" type="number" min="0" max="100" x-model="form.bobot_kelayakan" placeholder="60"></div>
                </div>
              </div>
              <div class="modal-footer">
                <button class="btn btn-secondary" @click="modal=''">Batal</button>
                <button class="btn btn-primary" @click="saveStandar">Simpan</button>
              </div>
            </div>
          </div>
        </div>

        <!-- ══ SLOT WAKTU ══ -->
        <div x-show="page==='slot'">
          <div class="breadcrumb"><span>Pengaturan Slot Waktu</span></div>
          <div class="card">
            <div class="card-header">
              <div class="card-title">⏰ Daftar Slot Waktu Lapangan</div>
              <button class="btn btn-primary btn-sm" @click="openModal('slot-add')">+ Tambah Slot</button>
            </div>
            <div class="table-wrap">
              <table>
                <thead><tr><th>No</th><th>Lapangan</th><th>Tipe Slot</th><th>Tanggal Mulai</th><th>Tanggal Selesai</th><th>Aksi</th></tr></thead>
                <tbody>
                  <template x-for="(s,i) in slotList" :key="s.id">
                    <tr>
                      <td x-text="i+1"></td>
                      <td x-text="s.lapangan ? s.lapangan.nama_lapangan : '—'"></td>
                      <td>
                        <span class="badge" :class="s.tipe_slot==='Reguler'?'badge-success':s.tipe_slot==='Turnamen'?'badge-info':'badge-warning'" x-text="s.tipe_slot"></span>
                      </td>
                      <td x-text="s.tanggal_mulai"></td>
                      <td x-text="s.tanggal_selesai"></td>
                      <td><button class="btn-icon delete" @click="deleteSlot(s.id)">🗑️</button></td>
                    </tr>
                  </template>
                  <tr x-show="slotList.length===0"><td colspan="6" class="empty-state"><p>Belum ada slot waktu</p></td></tr>
                </tbody>
              </table>
            </div>
          </div>

          <div class="modal-overlay" x-show="modal==='slot-add'" @click.self="modal=''">
            <div class="modal">
              <div class="modal-header"><div class="modal-title">Tambah Slot Waktu</div><button class="modal-close" @click="modal=''">✕</button></div>
              <div class="modal-body">
                <div class="field-group">
                  <label class="field-label">Lapangan *</label>
                  <select class="field-select" x-model="form.lapangan_id">
                    <option value="">-- Pilih Lapangan --</option>
                    <template x-for="l in lookups.lapangan" :key="l.id"><option :value="l.id" x-text="l.nama_lapangan"></option></template>
                  </select>
                </div>
                <div class="field-group">
                  <label class="field-label">Tipe Slot *</label>
                  <select class="field-select" x-model="form.tipe_slot">
                    <option value="">-- Pilih Tipe --</option>
                    <option>Reguler</option><option>Turnamen</option><option>Perawatan</option>
                  </select>
                </div>
                <div class="field-group">
                  <label class="field-label">Rentang Tanggal *</label>
                  <input class="field-input" id="slotDateRange" placeholder="Pilih rentang tanggal" readonly>
                  <div class="field-hint">Klik untuk memilih tanggal mulai - selesai</div>
                </div>
              </div>
              <div class="modal-footer">
                <button class="btn btn-secondary" @click="modal=''">Batal</button>
                <button class="btn btn-primary" @click="saveSlot">Simpan</button>
              </div>
            </div>
          </div>
        </div>

        <!-- ══ TARGET KETERISIAN ══ -->
        <div x-show="page==='target'">
          <div class="breadcrumb"><span>Target Keterisian & Evaluasi Okupansi</span></div>

          <div class="filter-bar">
            <div class="filter-group">
              <label class="filter-label">Tahun</label>
              <select class="filter-select" x-model="targetFilter.tahun" @change="loadTarget">
                <option value="">Semua Tahun</option>
                <option>2026</option><option>2025</option>
              </select>
            </div>
            <div class="filter-group">
              <label class="filter-label">Cabang</label>
              <select class="filter-select" x-model="targetFilter.cabang_id" @change="loadTarget">
                <option value="">Semua Cabang</option>
                <template x-for="c in lookups.cabang" :key="c.id"><option :value="c.id" x-text="c.nama_cabang"></option></template>
              </select>
            </div>
            <div style="margin-left:auto"><button class="btn btn-primary btn-sm" @click="openModal('target-add')">+ Tambah Target</button></div>
          </div>

          <div class="card">
            <div class="table-wrap">
              <table>
                <thead><tr>
                  <th>No</th>
                  <th @click="sortTarget('nama_lapangan')">Lapangan <span class="sort-icon">⇅</span></th>
                  <th>Bulan</th>
                  <th @click="sortTarget('target_jam')">Target Jam <span class="sort-icon">⇅</span></th>
                  <th @click="sortTarget('realisasi_jam')">Realisasi <span class="sort-icon">⇅</span></th>
                  <th>Okupansi</th>
                  <th>Status</th>
                  <th>Aksi</th>
                </tr></thead>
                <tbody>
                  <template x-for="(t,i) in targetList" :key="t.id">
                    <tr>
                      <td x-text="i+1"></td>
                      <td x-text="t.lapangan ? t.lapangan.nama_lapangan : '—'"></td>
                      <td x-text="(t.bulan && ['','Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'][t.bulan] || '—') + ' ' + t.tahun"></td>
                      <td x-text="t.target_jam + ' jam'"></td>
                      <td x-text="(t.realisasi_jam||0) + ' jam'"></td>
                      <td style="min-width:120px">
                        <div style="display:flex;align-items:center;gap:8px">
                          <div class="occ-bar" style="flex:1">
                            <div class="occ-fill" :style="'width:'+Math.min(100,Math.round(((t.realisasi_jam||0)/t.target_jam)*100))+'%;background:'+(((t.realisasi_jam||0)/t.target_jam)>=.8?'#10b981':((t.realisasi_jam||0)/t.target_jam)>=.5?'#f59e0b':'#ef4444')"></div>
                          </div>
                          <span style="font-size:12px;font-weight:600;min-width:36px" x-text="Math.min(100,Math.round(((t.realisasi_jam||0)/t.target_jam)*100))+'%'"></span>
                        </div>
                      </td>
                      <td>
                        <span class="badge" :class="((t.realisasi_jam||0)/t.target_jam)>=.8?'badge-success':((t.realisasi_jam||0)/t.target_jam)>=.5?'badge-warning':'badge-danger'"
                          x-text="((t.realisasi_jam||0)/t.target_jam)>=.8?'Tercapai':((t.realisasi_jam||0)/t.target_jam)>=.5?'Sebagian':'Di Bawah Target'">
                        </span>
                      </td>
                      <td>
                        <div class="action-btns">
                          <button class="btn-icon edit" @click="editTarget(t)">✏️</button>
                          <button class="btn-icon delete" @click="deleteTarget(t.id)">🗑️</button>
                        </div>
                      </td>
                    </tr>
                  </template>
                  <tr x-show="targetList.length===0"><td colspan="8" class="empty-state"><p>Belum ada data target</p></td></tr>
                </tbody>
              </table>
            </div>
          </div>

          <div class="modal-overlay" x-show="modal==='target-add' || modal==='target-edit'" @click.self="modal=''">
            <div class="modal">
              <div class="modal-header"><div class="modal-title" x-text="editingId ? 'Edit Target Keterisian' : 'Tambah Target Keterisian'"></div><button class="modal-close" @click="modal=''">✕</button></div>
              <div class="modal-body">
                <div class="field-group">
                  <label class="field-label">Lapangan *</label>
                  <select class="field-select" x-model="form.lapangan_id">
                    <option value="">-- Pilih Lapangan --</option>
                    <template x-for="l in lookups.lapangan" :key="l.id"><option :value="l.id" x-text="l.nama_lapangan"></option></template>
                  </select>
                </div>
                <div class="form-row">
                  <div class="field-group"><label class="field-label">Tahun *</label><input class="field-input" type="number" x-model="form.tahun" placeholder="2026"></div>
                  <div class="field-group">
                    <label class="field-label">Bulan *</label>
                    <select class="field-select" x-model="form.bulan">
                      <option value="">-- Pilih Bulan --</option>
                      <template x-for="(b,bi) in ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des']" :key="bi">
                        <option :value="bi+1" x-text="b"></option>
                      </template>
                    </select>
                  </div>
                </div>
                <div class="form-row">
                  <div class="field-group"><label class="field-label">Target Jam *</label><input class="field-input" type="number" x-model="form.target_jam" placeholder="120"></div>
                  <div class="field-group"><label class="field-label">Realisasi Jam</label><input class="field-input" type="number" x-model="form.realisasi_jam" placeholder="0"></div>
                </div>
              </div>
              <div class="modal-footer">
                <button class="btn btn-secondary" @click="modal=''">Batal</button>
                <button class="btn btn-primary" @click="saveTarget">Simpan</button>
              </div>
            </div>
          </div>
        </div>

        <!-- ══ STAF QC ══ -->
        <div x-show="page==='staf-qc'">
          <div class="breadcrumb"><span>Manajemen Staf QC</span></div>
          <div class="card">
            <div class="card-header">
              <div class="card-title">👷 Daftar Staf Pengawas QC</div>
              <button class="btn btn-primary btn-sm" @click="openModal('qc-add')">+ Tambah Staf QC</button>
            </div>
            <div class="table-wrap">
              <table>
                <thead><tr><th>No</th><th>NIK</th><th>Nama Staf</th><th>Gelar</th><th>Jabatan</th><th>Jenis Kelamin</th><th>Plotting Wilayah</th><th>Lapangan Tugas</th><th>Aksi</th></tr></thead>
                <tbody>
                  <template x-for="(s,i) in stafQCList" :key="s.id">
                    <tr>
                      <td x-text="i+1"></td>
                      <td><code style="font-size:12px;background:#f1f5f9;padding:2px 6px;border-radius:4px" x-text="s.nik"></code></td>
                      <td><strong x-text="s.nama_staf"></strong></td>
                      <td x-text="s.gelar||'—'"></td>
                      <td x-text="s.jabatan"></td>
                      <td><span class="badge" :class="s.jenis_kelamin==='L'?'badge-info':'badge-purple'" x-text="s.jenis_kelamin==='L'?'Laki-laki':'Perempuan'"></span></td>
                      <td x-text="s.cabang ? s.cabang.nama_cabang : '—'"></td>
                      <td x-text="s.lapangan ? s.lapangan.nama_lapangan : '—'"></td>
                      <td>
                        <div class="action-btns">
                          <button class="btn-icon edit" @click="editStafQC(s)">✏️</button>
                          <button class="btn-icon delete" @click="deleteStafQC(s.id)">🗑️</button>
                        </div>
                      </td>
                    </tr>
                  </template>
                  <tr x-show="stafQCList.length===0"><td colspan="9" class="empty-state"><p>Belum ada staf QC</p></td></tr>
                </tbody>
              </table>
            </div>
          </div>

          <div class="modal-overlay" x-show="modal==='qc-add' || modal==='qc-edit'" @click.self="modal=''">
            <div class="modal modal-lg">
              <div class="modal-header"><div class="modal-title" x-text="editingId ? 'Edit Staf QC' : 'Tambah Staf QC'"></div><button class="modal-close" @click="modal=''">✕</button></div>
              <div class="modal-body">
                <div class="form-row">
                  <div class="field-group"><label class="field-label">NIK / Nomor Induk *</label><input class="field-input" x-model="form.nik" placeholder="QC-3174-001"></div>
                  <div class="field-group"><label class="field-label">Gelar</label><input class="field-input" x-model="form.gelar" placeholder="S.T., M.M., dll"></div>
                </div>
                <div class="form-row">
                  <div class="field-group"><label class="field-label">Nama Lengkap *</label><input class="field-input" x-model="form.nama_staf" placeholder="Nama lengkap staf"></div>
                  <div class="field-group">
                    <label class="field-label">Jenis Kelamin *</label>
                    <select class="field-select" x-model="form.jenis_kelamin">
                      <option value="">-- Pilih --</option>
                      <option value="L">Laki-laki</option>
                      <option value="P">Perempuan</option>
                    </select>
                  </div>
                </div>
                <div class="field-group"><label class="field-label">Jabatan *</label><input class="field-input" x-model="form.jabatan" placeholder="Senior QC Inspector"></div>
                <div class="form-row">
                  <div class="field-group">
                    <label class="field-label">Plotting Wilayah Cabang *</label>
                    <select class="field-select" x-model="form.cabang_id">
                      <option value="">-- Pilih Cabang --</option>
                      <template x-for="c in lookups.cabang" :key="c.id"><option :value="c.id" x-text="c.nama_cabang"></option></template>
                    </select>
                  </div>
                  <div class="field-group">
                    <label class="field-label">Lapangan Tugas *</label>
                    <select class="field-select" x-model="form.lapangan_id">
                      <option value="">-- Pilih Lapangan --</option>
                      <template x-for="l in lookups.lapangan" :key="l.id"><option :value="l.id" x-text="l.nama_lapangan"></option></template>
                    </select>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button class="btn btn-secondary" @click="modal=''">Batal</button>
                <button class="btn btn-primary" @click="saveStafQC">Simpan</button>
              </div>
            </div>
          </div>
        </div>

        <!-- ══ KATEGORI TEMUAN ══ -->
        <div x-show="page==='temuan'">
          <div class="breadcrumb"><span>Kategori Temuan Kerusakan</span></div>
          <div style="display:grid;grid-template-columns:1fr 1fr;gap:24px">
            <div class="card">
              <div class="card-header"><div class="card-title">⚠️ Form Tambah Temuan</div></div>
              <div class="card-body">
                <div class="field-group"><label class="field-label">Nama Temuan *</label><input class="field-input" x-model="form.nama_temuan" placeholder="Contoh: Lantai Licin, Jaring Robek..."></div>
                <div class="field-group">
                  <label class="field-label">Jenis Temuan *</label>
                  <div class="radio-group">
                    <label class="radio-option">
                      <input type="radio" name="jenis_temuan" value="Positif" x-model="form.jenis_temuan">
                      <span class="radio-label">✅ Temuan Positif (Fasilitas Bagus)</span>
                    </label>
                    <label class="radio-option">
                      <input type="radio" name="jenis_temuan" value="Negatif" x-model="form.jenis_temuan">
                      <span class="radio-label">❌ Temuan Negatif (Fasilitas Rusak)</span>
                    </label>
                  </div>
                </div>
                <button class="btn btn-primary" @click="saveTemuan">Simpan Temuan</button>
              </div>
            </div>
            <div class="card">
              <div class="card-header"><div class="card-title">📋 Daftar Kategori Temuan</div></div>
              <div class="table-wrap">
                <table>
                  <thead><tr><th>No</th><th>Nama Temuan</th><th>Jenis</th><th>Aksi</th></tr></thead>
                  <tbody>
                    <template x-for="(t,i) in temuanList" :key="t.id">
                      <tr>
                        <td x-text="i+1"></td>
                        <td x-text="t.nama_temuan"></td>
                        <td><span class="badge" :class="t.jenis_temuan==='Positif'?'badge-success':'badge-danger'" x-text="t.jenis_temuan"></span></td>
                        <td><button class="btn-icon delete" @click="deleteTemuan(t.id)">🗑️</button></td>
                      </tr>
                    </template>
                    <tr x-show="temuanList.length===0"><td colspan="4" class="empty-state"><p>Belum ada kategori temuan</p></td></tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>

        <!-- ══ REKAP KELAYAKAN ══ -->
        <div x-show="page==='rekap'">
          <div class="breadcrumb"><span>Rekap Nilai Kelayakan (Desk Evaluation)</span></div>
          <div style="display:flex;align-items:center;gap:12px;margin-bottom:20px;flex-wrap:wrap">
            <div class="search-bar" style="flex:1;min-width:200px">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
              <input type="text" placeholder="Cari lapangan, kode..." x-model="rekapSearch" @input.debounce.400="loadRekap">
            </div>
            <button class="btn btn-primary btn-sm" @click="openModal('rekap-add')">+ Tambah Rekap</button>
          </div>

          <div class="card">
            <div class="table-wrap">
              <table>
                <thead><tr>
                  <th>No</th>
                  <th @click="sortRekap('lapangan')">Nama Lapangan <span class="sort-icon">⇅</span></th>
                  <th @click="sortRekap('target_keterisian_jam')">Target Keterisian <span class="sort-icon">⇅</span></th>
                  <th @click="sortRekap('nilai_kondisi_mandiri')">Nilai Mandiri <span class="sort-icon">⇅</span></th>
                  <th @click="sortRekap('nilai_tim_qc')">Nilai Tim QC <span class="sort-icon">⇅</span></th>
                  <th @click="sortRekap('grade')">Grade <span class="sort-icon">⇅</span></th>
                  <th>Status Kelayakan</th>
                  <th>Aksi</th>
                </tr></thead>
                <tbody>
                  <template x-for="(r,i) in rekapList" :key="r.id">
                    <tr>
                      <td x-text="i+1"></td>
                      <td><strong x-text="r.lapangan ? r.lapangan.nama_lapangan : '—'"></strong></td>
                      <td x-text="r.target_keterisian_jam + ' jam'"></td>
                      <td>
                        <div style="display:flex;align-items:center;gap:8px">
                          <div class="occ-bar" style="width:80px">
                            <div class="occ-fill" :style="'width:'+r.nilai_kondisi_mandiri+'%;background:var(--primary)'"></div>
                          </div>
                          <span x-text="r.nilai_kondisi_mandiri + '%'"></span>
                        </div>
                      </td>
                      <td>
                        <div style="display:flex;align-items:center;gap:8px">
                          <div class="occ-bar" style="width:80px">
                            <div class="occ-fill" :style="'width:'+r.nilai_tim_qc+'%;background:var(--accent)'"></div>
                          </div>
                          <span x-text="r.nilai_tim_qc + '%'"></span>
                        </div>
                      </td>
                      <td><span class="badge" :class="r.grade==='A'?'badge-success':r.grade==='B'?'badge-info':r.grade==='C'?'badge-warning':'badge-danger'" x-text="r.grade"></span></td>
                      <td>
                        <div class="stars" x-text="'★'.repeat(Math.max(0, Math.min(5, Math.floor(r.bintang||0)))) + '☆'.repeat(Math.max(0, 5 - Math.max(0, Math.min(5, Math.floor(r.bintang||0)))))"></div>
                      </td>
                      <td>
                        <div class="action-btns">
                          <button class="btn-icon edit" @click="editRekap(r)">✏️</button>
                          <button class="btn-icon delete" @click="deleteRekap(r.id)">🗑️</button>
                        </div>
                      </td>
                    </tr>
                  </template>
                  <tr x-show="rekapList.length===0"><td colspan="8" class="empty-state"><p>Belum ada rekap kelayakan</p></td></tr>
                </tbody>
              </table>
            </div>
            <!-- Pagination -->
            <div style="display:flex;align-items:center;justify-content:space-between;padding:16px 20px;border-top:1px solid var(--border)">
              <span style="font-size:13px;color:var(--text-muted)">Halaman <strong x-text="rekapPage"></strong> dari <strong x-text="rekapTotalPages"></strong></span>
              <div class="pagination">
                <button class="page-btn" :disabled="rekapPage===1" @click="rekapPage--;loadRekap()">‹</button>
                <template x-for="p in rekapTotalPages" :key="p">
                  <button class="page-btn" :class="{active:rekapPage===p}" @click="rekapPage=p;loadRekap()" x-text="p"></button>
                </template>
                <button class="page-btn" :disabled="rekapPage===rekapTotalPages" @click="rekapPage++;loadRekap()">›</button>
              </div>
            </div>
          </div>

          <div class="modal-overlay" x-show="modal==='rekap-add' || modal==='rekap-edit'" @click.self="modal=''">
            <div class="modal">
              <div class="modal-header"><div class="modal-title" x-text="editingId ? 'Edit Rekap Kelayakan' : 'Tambah Rekap Kelayakan'"></div><button class="modal-close" @click="modal=''">✕</button></div>
              <div class="modal-body">
                <div class="field-group">
                  <label class="field-label">Lapangan *</label>
                  <select class="field-select" x-model="form.lapangan_id">
                    <option value="">-- Pilih Lapangan --</option>
                    <template x-for="l in lookups.lapangan" :key="l.id"><option :value="l.id" x-text="l.nama_lapangan"></option></template>
                  </select>
                </div>
                <div class="field-group"><label class="field-label">Target Keterisian Jam *</label><input class="field-input" type="number" x-model="form.target_keterisian_jam" placeholder="120"></div>
                <div class="form-row">
                  <div class="field-group"><label class="field-label">Nilai Kondisi Mandiri (%) *</label><input class="field-input" type="number" min="0" max="100" x-model="form.nilai_kondisi_mandiri"></div>
                  <div class="field-group"><label class="field-label">Nilai Tim QC (%) *</label><input class="field-input" type="number" min="0" max="100" x-model="form.nilai_tim_qc"></div>
                </div>
                <div class="form-row">
                  <div class="field-group">
                    <label class="field-label">Grade *</label>
                    <select class="field-select" x-model="form.grade">
                      <option>A</option><option>B</option><option>C</option><option>D</option><option>E</option>
                    </select>
                  </div>
                  <div class="field-group">
                    <label class="field-label">Bintang (1-5) *</label>
                    <select class="field-select" x-model="form.bintang">
                      <option>1</option><option>2</option><option>3</option><option>4</option><option>5</option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button class="btn btn-secondary" @click="modal=''">Batal</button>
                <button class="btn btn-primary" @click="saveRekap">Simpan</button>
              </div>
            </div>
          </div>
        </div>

        <!-- ══ USERS MEMBER ══ -->
        <div x-show="page==='users-member'">
          <div class="breadcrumb"><span>Manajemen Pengguna</span> / <span>Data Pengguna Portal</span></div>
          <div class="card">
            <div class="card-header">
              <div class="card-title">👥 Data Pengguna Portal (Member / Penyewa)</div>
              <button class="btn btn-primary btn-sm" @click="openModal('member-add')">+ Tambah Member</button>
            </div>
            <div class="table-wrap">
              <table>
                <thead><tr><th>No</th><th>Nama Pengguna</th><th>Nama Asli</th><th>Email</th><th>Group Member</th><th>Status</th><th>Aksi</th></tr></thead>
                <tbody>
                  <template x-for="(u,i) in memberList" :key="u.id">
                    <tr>
                      <td x-text="i+1"></td>
                      <td><code style="font-size:12px;background:#f1f5f9;padding:2px 6px;border-radius:4px" x-text="u.username"></code></td>
                      <td><strong x-text="u.name"></strong></td>
                      <td style="font-size:12px;color:var(--text-muted)" x-text="u.email"></td>
                      <td><span class="badge badge-purple" x-text="u.member_group ? u.member_group.name : '—'"></span></td>
                      <td><span class="badge" :class="u.is_active ? 'badge-success':'badge-danger'" x-text="u.is_active ? 'Aktif':'Nonaktif'"></span></td>
                      <td>
                        <div class="action-btns">
                          <button class="btn-icon edit" title="Edit Member" @click="editMember(u)">✏️</button>
                          <button class="btn-icon delete" title="Hapus Member" @click="deleteMember(u.id)">🗑️</button>
                          <button class="btn-icon blue" :title="u.is_active ? 'Kunci Akun':'Aktifkan Akun'" @click="toggleMember(u.id)">
                            <span x-text="u.is_active ? '🔒':'🔓'"></span>
                          </button>
                        </div>
                      </td>
                    </tr>
                  </template>
                  <tr x-show="memberList.length===0"><td colspan="7" class="empty-state"><p>Belum ada pengguna portal</p></td></tr>
                </tbody>
              </table>
            </div>
          </div>

          <div class="modal-overlay" x-show="modal==='member-add'||modal==='member-edit'" @click.self="modal=''">
            <div class="modal">
              <div class="modal-header">
                <div class="modal-title" x-text="modal==='member-add'?'Tambah Member Portal':'Edit Member Portal'"></div>
                <button class="modal-close" @click="modal=''">✕</button>
              </div>
              <div class="modal-body">
                <div class="form-row">
                  <div class="field-group"><label class="field-label">Nama Asli *</label><input class="field-input" x-model="form.name" placeholder="Nama lengkap"></div>
                  <div class="field-group"><label class="field-label">Username *</label><input class="field-input" x-model="form.username" placeholder="username_unik"></div>
                </div>
                <div class="field-group"><label class="field-label">Email *</label><input class="field-input" type="email" x-model="form.email" placeholder="email@contoh.com"></div>
                <div class="form-row">
                  <div class="field-group">
                    <label class="field-label">Group Member *</label>
                    <select class="field-select" x-model="form.member_group_id">
                      <option value="">-- Pilih Group --</option>
                      <template x-for="g in lookups.member_groups" :key="g.id"><option :value="g.id" x-text="g.name"></option></template>
                    </select>
                  </div>
                  <div class="field-group">
                    <label class="field-label">Status</label>
                    <select class="field-select" x-model="form.is_active">
                      <option :value="true">Aktif</option>
                      <option :value="false">Nonaktif</option>
                    </select>
                  </div>
                </div>
                <div class="field-group"><label class="field-label">Password <span x-show="modal==='member-edit'" style="color:var(--text-muted);font-weight:400">(kosongkan jika tidak diubah)</span></label><input class="field-input" type="password" x-model="form.password" placeholder="••••••••"></div>
              </div>
              <div class="modal-footer">
                <button class="btn btn-secondary" @click="modal=''">Batal</button>
                <button class="btn btn-primary" @click="saveMember">Simpan</button>
              </div>
            </div>
          </div>
        </div>

        <!-- ══ USERS STAFF ══ -->
        <div x-show="page==='users-staff'">
          <div class="breadcrumb"><span>Manajemen Pengguna</span> / <span>Pengguna Backoffice</span></div>
          <div class="card">
            <div class="card-header">
              <div class="card-title">🏢 Manajemen Pengguna Backoffice (Staf / Admin)</div>
              <button class="btn btn-primary btn-sm" @click="openModal('staff-add')">+ Tambah Staf</button>
            </div>
            <div class="table-wrap">
              <table>
                <thead><tr><th>No</th><th>Aksi</th><th>Username</th><th>Nama Lengkap</th><th>Role Group</th><th>Unit Cabang</th><th>Status</th></tr></thead>
                <tbody>
                  <template x-for="(u,i) in staffList" :key="u.id">
                    <tr>
                      <td x-text="i+1"></td>
                      <td><div class="action-btns">
                        <button class="btn-icon edit" @click="editStaff(u)">✏️</button>
                        <button class="btn-icon delete" @click="deleteStaff(u.id)">🗑️</button>
                      </div></td>
                      <td><code style="font-size:12px;background:#f1f5f9;padding:2px 6px;border-radius:4px" x-text="u.username"></code></td>
                      <td><strong x-text="u.name"></strong></td>
                      <td><span class="badge badge-purple" x-text="u.role ? u.role.display_name : '—'"></span></td>
                      <td x-text="u.cabang ? u.cabang.nama_cabang : 'Pusat'"></td>
                      <td><span class="badge" :class="u.is_active?'badge-success':'badge-danger'" x-text="u.is_active?'Aktif':'Nonaktif'"></span></td>
                    </tr>
                  </template>
                  <tr x-show="staffList.length===0"><td colspan="7" class="empty-state"><p>Belum ada staf backoffice</p></td></tr>
                </tbody>
              </table>
            </div>
          </div>

          <!-- Tip Card -->
          <div class="tip-card">
            <div class="tip-card-title">ℹ️ Petunjuk Operasional Manajemen Staf</div>
            <ul class="tip-list">
              <li>Gunakan tombol ✏️ <strong>Edit</strong> untuk mengubah data staf termasuk role dan unit cabang.</li>
              <li>Gunakan tombol 🗑️ <strong>Hapus</strong> untuk menghapus akun staf secara permanen dari sistem.</li>
              <li>Role <strong>Admin Pusat</strong> memiliki akses penuh ke seluruh modul sistem.</li>
              <li>Role <strong>Kasir</strong> hanya dapat mengelola transaksi dan pemesanan lapangan.</li>
              <li>Role <strong>Supervisor</strong> bertugas mengawasi operasional di cabang tertentu.</li>
              <li>Untuk mencari staf, gunakan fitur pencarian browser (Ctrl+F) atau hubungi Admin Pusat.</li>
            </ul>
          </div>

          <div class="modal-overlay" x-show="modal==='staff-add'||modal==='staff-edit'" @click.self="modal=''">
            <div class="modal">
              <div class="modal-header">
                <div class="modal-title" x-text="modal==='staff-add'?'Tambah Staf Backoffice':'Edit Staf Backoffice'"></div>
                <button class="modal-close" @click="modal=''">✕</button>
              </div>
              <div class="modal-body">
                <div class="form-row">
                  <div class="field-group"><label class="field-label">Nama Lengkap *</label><input class="field-input" x-model="form.name" placeholder="Nama lengkap staf"></div>
                  <div class="field-group"><label class="field-label">Username *</label><input class="field-input" x-model="form.username" placeholder="username_staf"></div>
                </div>
                <div class="field-group"><label class="field-label">Email *</label><input class="field-input" type="email" x-model="form.email" placeholder="staf@sewalapangan.com"></div>
                <div class="form-row">
                  <div class="field-group">
                    <label class="field-label">Role Group *</label>
                    <select class="field-select" x-model="form.role_id">
                      <option value="">-- Pilih Role --</option>
                      <template x-for="r in lookups.roles" :key="r.id"><option :value="r.id" x-text="r.display_name"></option></template>
                    </select>
                  </div>
                  <div class="field-group">
                    <label class="field-label">Unit Cabang</label>
                    <select class="field-select" x-model="form.cabang_id">
                      <option value="">Pusat / Tidak Ada</option>
                      <template x-for="c in lookups.cabang" :key="c.id"><option :value="c.id" x-text="c.nama_cabang"></option></template>
                    </select>
                  </div>
                </div>
                <div class="form-row">
                  <div class="field-group">
                    <label class="field-label">Status</label>
                    <select class="field-select" x-model="form.is_active">
                      <option :value="true">Aktif</option>
                      <option :value="false">Nonaktif</option>
                    </select>
                  </div>
                  <div class="field-group"><label class="field-label">Password <span x-show="modal==='staff-edit'" style="color:var(--text-muted);font-weight:400">(kosongkan jika tidak diubah)</span></label><input class="field-input" type="password" x-model="form.password" placeholder="••••••••"></div>
                </div>
              </div>
              <div class="modal-footer">
                <button class="btn btn-secondary" @click="modal=''">Batal</button>
                <button class="btn btn-primary" @click="saveStaff">Simpan</button>
              </div>
            </div>
          </div>
        </div>

      <div class="modal-overlay" x-show="modal==='lap-add'||modal==='lap-edit'" @click.self="modal=''">
        <div class="modal modal-lg">
          <div class="modal-header">
            <div class="modal-title" x-text="modal==='lap-add'?'Tambah Data Lapangan':'Edit Data Lapangan'"></div>
            <button class="modal-close" @click="modal=''">✕</button>
          </div>
          <div class="modal-body">
            <div class="form-row">
              <div class="field-group">
                <label class="field-label">Hub Pusat *</label>
                <select class="field-select" x-model="form.hub_pusat_id">
                  <option value="">-- Pilih Hub --</option>
                  <template x-for="h in lookups.hub" :key="h.id"><option :value="h.id" x-text="h.nama_hub"></option></template>
                </select>
              </div>
              <div class="field-group">
                <label class="field-label">Cabang *</label>
                <select class="field-select" x-model="form.cabang_id">
                  <option value="">-- Pilih Cabang --</option>
                  <template x-for="c in lookups.cabang" :key="c.id"><option :value="c.id" x-text="c.nama_cabang"></option></template>
                </select>
              </div>
            </div>
            <div class="form-row">
              <div class="field-group"><label class="field-label">Kode *</label><input class="field-input" x-model="form.kode" placeholder="LAP-BDM-01"></div>
              <div class="field-group"><label class="field-label">Nama Lapangan *</label><input class="field-input" x-model="form.nama_lapangan" placeholder="Nama lengkap lapangan"></div>
            </div>
            <div class="form-row">
              <div class="field-group">
                <label class="field-label">Kategori / Jenjang *</label>
                <select class="field-select" x-model="form.kategori_lapangan_id">
                  <option value="">-- Pilih Kategori --</option>
                  <template x-for="k in lookups.kategori" :key="k.id"><option :value="k.id" x-text="k.nama_kategori"></option></template>
                </select>
              </div>
              <div class="field-group">
                <label class="field-label">Akreditasi Kualitas *</label>
                <select class="field-select" x-model="form.akreditasi">
                  <option value="">-- Pilih --</option>
                  <option>A</option><option>B</option><option>C</option><option>Unggul</option>
                </select>
              </div>
            </div>
            <div class="form-row">
              <div class="field-group"><label class="field-label">Nomor SK / Izin *</label><input class="field-input" x-model="form.nomor_sk" placeholder="SK/LAP/2026/001"></div>
              <div class="field-group"><label class="field-label">Tanggal Sertifikasi *</label><input class="field-input" type="date" x-model="form.tanggal_sertifikasi"></div>
            </div>
            <div class="field-group"><label class="field-label">Alamat</label><textarea class="field-textarea" x-model="form.alamat" placeholder="Alamat lengkap lapangan"></textarea></div>
            <div class="field-group">
              <label class="field-label">Dokumen Legalitas (PDF, maks 2MB)</label>
              <input class="field-file" type="file" accept=".pdf" @change="form.dokumen_legalitas = $event.target.files[0]">
              <div class="field-hint">Hanya file PDF dengan ukuran maksimal 2MB</div>
            </div>
            <div class="field-group" style="margin-top:12px">
              <label class="field-label">Foto Lapangan (JPG, PNG, WebP, maks 2MB)</label>
              <input class="field-file" type="file" accept="image/*" @change="handleFotoUpload($event)">
              <div class="field-hint">Format gambar (JPG, PNG, WebP) dengan ukuran maksimal 2MB</div>
              <template x-if="form.foto_preview">
                <div style="margin-top:8px">
                  <img :src="form.foto_preview" style="max-height:100px;border-radius:6px;object-fit:cover;border:1px solid var(--border)">
                </div>
              </template>
            </div>
          </div>
          <div class="modal-footer">
            <button class="btn btn-secondary" @click="modal=''">Batal</button>
            <button class="btn btn-primary" @click="saveLapangan">Simpan</button>
          </div>
        </div>
      </div>

      </div><!-- end page-content -->
    </div><!-- end main-wrap -->
  </div><!-- end app-wrap -->
</div>

<script>
function sportsApp() {
  return {
    // ── Auth ──────────────────────────────────────────────────────────────
    isAuth: false,
    currentUser: null,
    loginForm: { username: '', password: '' },
    loginLoading: false,
    loginError: '',

    // ── UI State ─────────────────────────────────────────────────────────
    page: 'dashboard',
    pageTitle: 'Dashboard',
    sidebarCollapsed: false,
    showLanding: !sessionStorage.getItem('sportspace_user'),
    modal: '',
    form: {},
    toasts: [],
    deleteConfirm: { show: false, name: '', onConfirm: () => {} },

    // ── Search & Filter State ─────────────────────────────────────────────
    sewaSearch: '',
    sewaFilterCabang: '',
    sewaFilterKategori: '',
    lapanganSearch: '',

    // ── Data Lists ────────────────────────────────────────────────────────
    dashStats: {},
    musimList: [], mitraList: [], hubList: [], lapanganList: [],
    saranaList: [], dokumenList: [], tarifList: [], standarList: [],
    slotList: [], targetList: [], stafQCList: [], temuanList: [],
    rekapList: [], memberList: [], staffList: [],

    // ── Lookups ───────────────────────────────────────────────────────────
    lookups: { cabang: [], kategori: [], hub: [], lapangan: [], roles: [], member_groups: [] },

    // ── Filters ───────────────────────────────────────────────────────────
    dashFilter: { cabang_id: '', tahun: '', kategori_id: '' },
    dokumenFilter: { kategori: '', unit_pengunggah: '', jabatan_pengunggah: '' },
    tarifFilter: { tahun: '', cabang_id: '' },
    tarifTab: 'skema',
    targetFilter: { tahun: '', cabang_id: '' },
    rekapSearch: '', rekapPage: 1, rekapTotalPages: 1,
    expandAll: false,
    editingId: null,
    occupancyChart: null,
    quillEditor: null,

    // ═════════════════════════════════════════════════════════════════════
    async init() {
      const saved = sessionStorage.getItem('sportspace_user');
      if (saved) {
        this.currentUser = JSON.parse(saved);
        this.isAuth = true;
        await this.loadLookups();
        await this.loadDashboard();
      }
    },

    // ── Auth ──────────────────────────────────────────────────────────────
    async doLogin() {
      this.loginLoading = true; this.loginError = '';
      try {
        const r = await fetch(window.location.origin + '/api/login', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
          body: JSON.stringify(this.loginForm)
        });
        const d = await r.json();
        if (d.success) {
          this.currentUser = d.user;
          sessionStorage.setItem('sportspace_user', JSON.stringify(d.user));
          this.isAuth = true;
          await this.loadLookups();
          await this.loadDashboard();
          this.toast('success', 'Selamat datang, ' + d.user.name + '!');
        } else {
          this.loginError = d.message || 'Login gagal. Periksa kembali kredensial Anda.';
        }
      } catch(e) { this.loginError = 'Koneksi ke server gagal. Pastikan server berjalan.'; }
      this.loginLoading = false;
    },

    async doLogout() {
      await fetch(window.location.origin + '/api/logout', { method:'POST', headers:{'X-CSRF-TOKEN':'{{ csrf_token() }}','Accept':'application/json'} });
      sessionStorage.removeItem('sportspace_user');
      this.isAuth = false; this.currentUser = null;
      this.loginForm = { username:'', password:'' };
    },

    // ── Lookups ───────────────────────────────────────────────────────────
    async loadLookups() {
      try {
        const bUrl = window.location.origin;
        const [cabang, kategori, hub, lapangan, roles, member_groups] = await Promise.all([
          fetch(bUrl + '/api/lookup/cabang').then(r=>r.ok ? r.json() : []),
          fetch(bUrl + '/api/lookup/kategori').then(r=>r.ok ? r.json() : []),
          fetch(bUrl + '/api/lookup/hub').then(r=>r.ok ? r.json() : []),
          fetch(bUrl + '/api/lookup/lapangan').then(r=>r.ok ? r.json() : []),
          fetch(bUrl + '/api/lookup/roles').then(r=>r.ok ? r.json() : []),
          fetch(bUrl + '/api/lookup/member-groups').then(r=>r.ok ? r.json() : []),
        ]).catch(e => {
          console.error('Error fetching lookups:', e);
          return [[], [], [], [], [], []];
        });
        this.lookups = {
          cabang: Array.isArray(cabang) ? cabang : [],
          kategori: Array.isArray(kategori) ? kategori : [],
          hub: Array.isArray(hub) ? hub : [],
          lapangan: Array.isArray(lapangan) ? lapangan : [],
          roles: Array.isArray(roles) ? roles : [],
          member_groups: Array.isArray(member_groups) ? member_groups : []
        };
      } catch (e) {
        console.error('loadLookups failed:', e);
      }
    },

    // ── Page switch ───────────────────────────────────────────────────────
    pageTitles: {
      'dashboard':'Dashboard', 'beranda':'Sewa Lapangan', 'alamat':'Alamat Cabang', 'about':'About Us',
      'musim':'Musim / Tahun Operasional', 'mitra':'Mitra Wilayah', 'hub':'Hub Pusat',
      'lapangan':'Data Detail Lapangan', 'sarana':'Sarana Fasilitas',
      'dokumen':'Manajemen Dokumen Operasional', 'tarif':'Tarif & Standar Fasilitas',
      'slot':'Pengaturan Slot Waktu', 'target':'Target Keterisian & Evaluasi',
      'staf-qc':'Manajemen Staf QC', 'temuan':'Kategori Temuan Kerusakan',
      'rekap':'Rekap Nilai Kelayakan', 'users-member':'Data Pengguna Portal',
      'users-staff':'Pengguna Backoffice'
    },

    async switchPage(p) {
      this.page = p;
      this.pageTitle = this.pageTitles[p] || p;
      this.modal = '';
      this.form = {};
      this.editingId = null;
      const loaders = {
        'dashboard': this.loadDashboard,
        'musim': this.loadMusim, 'mitra': this.loadMitra, 'hub': this.loadHub,
        'lapangan': this.loadLapangan, 'sarana': this.loadSarana,
        'dokumen': this.loadDokumen, 'tarif': ()=>{ this.loadTarif(); this.loadStandar(); },
        'slot': this.loadSlot, 'target': this.loadTarget, 'staf-qc': this.loadStafQC,
        'temuan': this.loadTemuan, 'rekap': this.loadRekap,
        'users-member': this.loadMembers, 'users-staff': this.loadStaff,
        'beranda': async () => { await this.loadLookups(); await this.loadLapangan(); },
        'alamat': this.loadLookups
      };
      if (loaders[p]) await loaders[p].call(this);
    },

    // ── Toast ─────────────────────────────────────────────────────────────
    toast(type, msg) {
      const id = Date.now() + Math.random();
      this.toasts.push({ id, type, msg, visible: true });
      setTimeout(() => { 
        const index = this.toasts.findIndex(x => x.id === id);
        if (index > -1) this.toasts[index].visible = false;
        setTimeout(() => { this.toasts = this.toasts.filter(x => x.id !== id); }, 300); 
      }, 3500);
    },

    openModal(name) {
      this.form = { is_active: true, jenis_temuan: 'Negatif', jenis_indikator: 'kualitatif' };
      this.editingId = null;
      this.modal = name;
      if (name === 'standar-add') {
        this.$nextTick(() => {
          if (!this.quillEditor) {
            this.quillEditor = new Quill('#quillEditor', { theme: 'snow', placeholder: 'Masukkan deskripsi fasilitas...' });
          }
        });
      }
      if (name === 'slot-add') {
        this.$nextTick(() => {
          flatpickr('#slotDateRange', {
            mode: 'range',
            dateFormat: 'Y-m-d',
            onChange: (dates) => {
              if (dates.length === 2) {
                this.form.tanggal_mulai = dates[0].toISOString().split('T')[0];
                this.form.tanggal_selesai = dates[1].toISOString().split('T')[0];
              }
            }
          });
        });
      }
    },

    handleFotoUpload(event) {
      const file = event.target.files[0];
      this.form.foto = file;
      if (file) {
        const reader = new FileReader();
        reader.onload = (e) => {
          this.form.foto_preview = e.target.result;
        };
        reader.readAsDataURL(file);
      } else {
        this.form.foto_preview = null;
      }
    },

    // ── API helper ────────────────────────────────────────────────────────
    async api(method, url, body = null, isFormData = false) {
      try {
        const opts = {
          method,
          headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
        };
        if (body && !isFormData) {
          opts.headers['Content-Type'] = 'application/json';
          opts.body = JSON.stringify(body);
        } else if (body && isFormData) {
          opts.body = body;
        }
        const fullUrl = url.startsWith('http') ? url : (window.location.origin + (url.startsWith('/') ? '' : '/') + url);
        const r = await fetch(fullUrl, opts);
        if (!r.ok) {
          const errData = await r.json().catch(() => ({}));
          return { success: false, message: errData.message || `HTTP error! status: ${r.status}` };
        }
        return await r.json();
      } catch (e) {
        console.error('API Error:', e);
        return { success: false, message: 'Gagal menghubungi server: ' + e.message };
      }
    },

    // ════════════════════════════════════════════════════════════════════
    // DASHBOARD
    // ════════════════════════════════════════════════════════════════════
    async loadDashboard() {
      const params = new URLSearchParams(this.dashFilter).toString();
      const d = await this.api('GET', '/api/dashboard?' + params);
      if (d && d.success) {
        this.dashStats = d.stats || {};
        this.$nextTick(() => this.renderChart(d.chart_data || []));
      } else {
        this.toast('error', (d && d.message) || 'Gagal memuat data dashboard');
      }
    },

    renderChart(data) {
      const ctx = document.getElementById('occupancyChart');
      if (!ctx) return;
      if (this.occupancyChart) { this.occupancyChart.destroy(); }
      this.occupancyChart = new Chart(ctx, {
        type: 'bar',
        data: {
          labels: data.map(d => d.lapangan + ' (Bln ' + d.bulan + ')'),
          datasets: [{
            label: 'Okupansi (%)',
            data: data.map(d => d.okupansi),
            backgroundColor: data.map(d => d.okupansi >= 80 ? 'rgba(16,185,129,.8)' : d.okupansi >= 50 ? 'rgba(245,158,11,.8)' : 'rgba(239,68,68,.8)'),
            borderRadius: 8, borderSkipped: false
          },{
            label: 'Target Jam',
            data: data.map(d => d.target),
            type: 'line', borderColor: '#6366f1', backgroundColor: 'rgba(99,102,241,.1)',
            tension: 0.4, fill: true, pointRadius: 5, pointBackgroundColor: '#6366f1', yAxisID: 'y2'
          }]
        },
        options: {
          responsive: true, maintainAspectRatio: false,
          plugins: { legend: { position: 'top' }, tooltip: { mode: 'index' } },
          scales: {
            y: { beginAtZero: true, max: 100, title: { display: true, text: 'Okupansi (%)' } },
            y2: { position: 'right', beginAtZero: true, title: { display: true, text: 'Jam' }, grid: { drawOnChartArea: false } }
          }
        }
      });
    },

    downloadChart() {
      if (!this.occupancyChart) return;
      const a = document.createElement('a');
      a.href = this.occupancyChart.toBase64Image();
      a.download = 'okupansi-lapangan.png';
      a.click();
      this.toast('success', 'Chart berhasil diunduh!');
    },

    // ════════════════════════════════════════════════════════════════════
    // MUSIM OPERASIONAL
    // ════════════════════════════════════════════════════════════════════
    async loadMusim() { const d = await this.api('GET','/api/musim'); if(d && d.success) this.musimList=d.data; else this.toast('error', (d && d.message) || 'Gagal memuat data musim'); },
    async saveMusim() {
      const url = this.editingId ? `/api/musim/${this.editingId}` : '/api/musim';
      const method = this.editingId ? 'PUT' : 'POST';
      const d = await this.api(method, url, { tahun: this.form.tahun, status: this.form.status });
      if (d.success) { this.toast('success', d.message||'Berhasil'); this.modal=''; await this.loadMusim(); }
      else { this.toast('error', Object.values(d.errors||{}).flat()[0] || d.message || 'Gagal'); }
    },
    editMusim(m) { this.editingId=m.id; this.form={tahun:m.tahun, status:m.status}; this.modal='musim-edit'; },
    async deleteMusim(id) {
      if(!confirm('Yakin hapus musim ini?')) return;
      const d = await this.api('DELETE',`/api/musim/${id}`);
      if(d.success) { this.toast('success','Musim berhasil dihapus'); await this.loadMusim(); }
      else this.toast('error', d.message||'Gagal');
    },

    // ════════════════════════════════════════════════════════════════════
    // MITRA WILAYAH
    // ════════════════════════════════════════════════════════════════════
    async loadMitra() { const d = await this.api('GET','/api/mitra'); if(d && d.success) this.mitraList=d.data; else this.toast('error', (d && d.message) || 'Gagal memuat data mitra'); },
    async saveMitra() {
      const url = this.editingId ? `/api/mitra/${this.editingId}` : '/api/mitra';
      const method = this.editingId ? 'PUT' : 'POST';
      const d = await this.api(method, url, this.form);
      if(d.success){ this.toast('success',d.message||'Berhasil'); this.modal=''; await this.loadMitra(); await this.loadLookups(); }
      else this.toast('error', Object.values(d.errors||{}).flat()[0]||d.message||'Gagal');
    },
    editMitra(m) { this.editingId=m.id; this.form={nama_cabang:m.nama_cabang,keterangan:m.keterangan,alamat:m.alamat,telepon:m.telepon}; this.modal='mitra-edit'; },
    async deleteMitra(id) {
      if(!confirm('Yakin hapus mitra ini?')) return;
      const d = await this.api('DELETE',`/api/mitra/${id}`);
      if(d.success){ this.toast('success','Mitra dihapus'); await this.loadMitra(); await this.loadLookups(); }
      else this.toast('error',d.message||'Gagal');
    },

    // ════════════════════════════════════════════════════════════════════
    // HUB PUSAT
    // ════════════════════════════════════════════════════════════════════
    async loadHub() { const d = await this.api('GET','/api/hub'); if(d && d.success) this.hubList=d.data; else this.toast('error', (d && d.message) || 'Gagal memuat data hub'); },
    async saveHub() {
      const url = this.editingId ? `/api/hub/${this.editingId}` : '/api/hub';
      const method = this.editingId ? 'PUT' : 'POST';
      const d = await this.api(method, url, {nama_hub:this.form.nama_hub, deskripsi:this.form.deskripsi});
      if(d.success){ this.toast('success',d.message||'Berhasil'); this.modal=''; await this.loadHub(); await this.loadLookups(); }
      else this.toast('error', Object.values(d.errors||{}).flat()[0]||d.message||'Gagal');
    },
    editHub(h) { this.editingId=h.id; this.form={nama_hub:h.nama_hub,deskripsi:h.deskripsi}; this.modal='hub-edit'; },
    async deleteHub(id) {
      if(!confirm('Yakin hapus hub ini?')) return;
      const d = await this.api('DELETE',`/api/hub/${id}`);
      if(d.success){ this.toast('success','Hub dihapus'); await this.loadHub(); await this.loadLookups(); }
      else this.toast('error',d.message||'Gagal');
    },

    // ════════════════════════════════════════════════════════════════════
    // LAPANGAN
    // ════════════════════════════════════════════════════════════════════
    async loadLapangan() { const d = await this.api('GET','/api/lapangan'); if(d && d.success) this.lapanganList=d.data; else this.toast('error', (d && d.message) || 'Gagal memuat data lapangan'); },
    
    getFilteredLapangan() {
      if (!this.lapanganList || !Array.isArray(this.lapanganList)) return [];
      return this.lapanganList.filter(l => {
        const matchSearch = !this.sewaSearch || (l.nama_lapangan && l.nama_lapangan.toLowerCase().includes(this.sewaSearch.toLowerCase())) || (l.kode && l.kode.includes(this.sewaSearch));
        const matchCabang = !this.sewaFilterCabang || l.cabang_id == this.sewaFilterCabang;
        const matchKategori = !this.sewaFilterKategori || l.kategori_lapangan_id == this.sewaFilterKategori;
        return matchSearch && matchCabang && matchKategori && l.is_active;
      });
    },

    getFilteredAdminLapangan() {
      if (!this.lapanganList || !Array.isArray(this.lapanganList)) return [];
      return this.lapanganList.filter(l => {
        return !this.lapanganSearch || (l.nama_lapangan && l.nama_lapangan.toLowerCase().includes(this.lapanganSearch.toLowerCase())) || (l.kode && l.kode.includes(this.lapanganSearch));
      });
    },

    async saveLapangan() {
      const fd = new FormData();
      const fields = ['hub_pusat_id','cabang_id','kategori_lapangan_id','kode','nama_lapangan','akreditasi','nomor_sk','tanggal_sertifikasi','alamat'];
      fields.forEach(f => { if(this.form[f] !== undefined && this.form[f] !== null) fd.append(f, this.form[f]); });
      if(this.form.dokumen_legalitas) fd.append('dokumen_legalitas', this.form.dokumen_legalitas);
      if(this.form.foto) fd.append('foto', this.form.foto);
      if(this.editingId) fd.append('_method','PUT');
      const url = this.editingId ? `${window.location.origin}/api/lapangan/${this.editingId}` : `${window.location.origin}/api/lapangan`;
      try {
        const r = await fetch(url, { method:'POST', headers:{'Accept':'application/json','X-CSRF-TOKEN':'{{ csrf_token() }}'}, body:fd });
        const d = await r.json();
        if(d.success){ this.toast('success',d.message||'Berhasil'); this.modal=''; await this.loadLapangan(); await this.loadLookups(); }
        else this.toast('error', Object.values(d.errors||{}).flat()[0]||d.message||'Gagal');
      } catch (e) {
        this.toast('error', 'Route error / Gagal terhubung ke API: ' + e.message);
      }
    },
    editLapangan(l) {
      this.editingId=l.id;
      this.form={hub_pusat_id:l.hub_pusat_id,cabang_id:l.cabang_id,kategori_lapangan_id:l.kategori_lapangan_id,
        kode:l.kode,nama_lapangan:l.nama_lapangan,akreditasi:l.akreditasi,
        nomor_sk:l.nomor_sk,tanggal_sertifikasi:l.tanggal_sertifikasi,alamat:l.alamat,foto_preview:l.foto};
      this.modal='lap-edit';
    },

    confirmDeleteLapangan(l) {
      this.deleteConfirm = {
        show: true,
        name: l.nama_lapangan,
        onConfirm: async () => {
          const d = await this.api('DELETE', `/api/lapangan/${l.id}`);
          if (d.success) {
            this.toast('success', `Lapangan "${l.nama_lapangan}" berhasil dihapus`);
            await this.loadLapangan();
            await this.loadLookups();
          } else {
            this.toast('error', d.message || 'Gagal menghapus lapangan');
          }
        }
      };
    },

    async deleteLapangan(id) {
      const d = await this.api('DELETE',`/api/lapangan/${id}`);
      if(d.success){ this.toast('success','Lapangan berhasil dihapus'); await this.loadLapangan(); await this.loadLookups(); }
      else this.toast('error',d.message||'Gagal menghapus lapangan');
    },

    // ════════════════════════════════════════════════════════════════════
    // SARANA FASILITAS
    // ════════════════════════════════════════════════════════════════════
    async loadSarana() { const d = await this.api('GET','/api/sarana'); if(d && d.success) this.saranaList=d.data; else this.toast('error', (d && d.message) || 'Gagal memuat data sarana'); },
    async saveSarana() {
      const url = this.editingId ? `/api/sarana/${this.editingId}` : '/api/sarana';
      const method = this.editingId ? 'PUT' : 'POST';
      const d = await this.api(method, url, {lapangan_id:this.form.lapangan_id,kode_fasilitas:this.form.kode_fasilitas,nama_unit:this.form.nama_unit,alamat:this.form.alamat});
      if(d.success){ this.toast('success',d.message||'Berhasil'); this.modal=''; await this.loadSarana(); }
      else this.toast('error',Object.values(d.errors||{}).flat()[0]||d.message||'Gagal');
    },
    editSarana(s) { this.editingId=s.id; this.form={lapangan_id:s.lapangan_id,kode_fasilitas:s.kode_fasilitas,nama_unit:s.nama_unit,alamat:s.alamat}; this.modal='sarana-edit'; },
    async deleteSarana(id) {
      if(!confirm('Yakin hapus sarana ini?')) return;
      const d = await this.api('DELETE',`/api/sarana/${id}`);
      if(d.success){ this.toast('success','Sarana dihapus'); await this.loadSarana(); }
    },

    // ════════════════════════════════════════════════════════════════════
    // DOKUMEN OPERASIONAL
    // ════════════════════════════════════════════════════════════════════
    async loadDokumen() {
      const p = new URLSearchParams(this.dokumenFilter).toString();
      const d = await this.api('GET','/api/dokumen?'+p); if(d && d.success) this.dokumenList=d.data; else this.toast('error', (d && d.message) || 'Gagal memuat data dokumen');
    },
    sortDokumen(col) { this.dokumenFilter.sort_by=col; this.dokumenFilter.sort_order = this.dokumenFilter.sort_order==='asc'?'desc':'asc'; this.loadDokumen(); },
    async saveDokumen() {
      const fd = new FormData();
      ['nama_dokumen','tahun','kategori','unit_pengunggah','jabatan_pengunggah'].forEach(f=>{ if(this.form[f]) fd.append(f,this.form[f]); });
      if(this.form.file_dokumen) fd.append('file_dokumen',this.form.file_dokumen);
      try {
        const r = await fetch(`${window.location.origin}/api/dokumen`,{method:'POST',headers:{'Accept':'application/json','X-CSRF-TOKEN':'{{ csrf_token() }}'},body:fd});
        const d = await r.json();
        if(d.success){ this.toast('success',d.message||'Berhasil'); this.modal=''; await this.loadDokumen(); }
        else this.toast('error', Object.values(d.errors||{}).flat()[0]||d.message||'Gagal');
      } catch(e) {
        this.toast('error', 'Gagal API: ' + e.message);
      }
    },
    async deleteDokumen(id) {
      if(!confirm('Yakin hapus dokumen ini?')) return;
      const d = await this.api('DELETE',`/api/dokumen/${id}`);
      if(d.success){ this.toast('success','Dokumen dihapus'); await this.loadDokumen(); }
    },

    // ════════════════════════════════════════════════════════════════════
    // TARIF SKEMA
    // ════════════════════════════════════════════════════════════════════
    async loadTarif() {
      const p = new URLSearchParams(this.tarifFilter).toString();
      const d = await this.api('GET','/api/tarif?'+p); if(d && d.success) this.tarifList=d.data; else this.toast('error', (d && d.message) || 'Gagal memuat data tarif');
    },
    async saveTarif() {
      const d = await this.api('POST','/api/tarif',{cabang_id:this.form.cabang_id,tahun:this.form.tahun,nilai_tarif:this.form.nilai_tarif,deskripsi_skema_jam:this.form.deskripsi_skema_jam,periode:this.form.periode,lokasi_lapangan:this.form.lokasi_lapangan});
      if(d.success){ this.toast('success',d.message||'Berhasil'); this.modal=''; await this.loadTarif(); }
      else this.toast('error',Object.values(d.errors||{}).flat()[0]||d.message||'Gagal');
    },
    async deleteTarif(id) {
      if(!confirm('Yakin hapus tarif ini?')) return;
      const d = await this.api('DELETE',`/api/tarif/${id}`);
      if(d.success){ this.toast('success','Tarif dihapus'); await this.loadTarif(); }
    },

    // ════════════════════════════════════════════════════════════════════
    // STANDAR FASILITAS
    // ════════════════════════════════════════════════════════════════════
    async loadStandar() {
      const d = await this.api('GET','/api/standar');
      if(d && d.success) this.standarList = d.data.map(p=>({...p, _open:false})); else this.toast('error', (d && d.message) || 'Gagal memuat data standar');
    },
    openAddChildStandar(parentId) { this.form={ parent_id: parentId, jenis_indikator:'kualitatif' }; this.modal='standar-add'; this.$nextTick(()=>{ if(!this.quillEditor) this.quillEditor=new Quill('#quillEditor',{theme:'snow'}); }); },
    async saveStandar() {
      const deskripsi = this.quillEditor ? this.quillEditor.root.innerHTML : this.form.deskripsi||'';
      const d = await this.api('POST','/api/standar',{parent_id:this.form.parent_id||null,nama_fasilitas:this.form.nama_fasilitas,deskripsi,jenis_indikator:this.form.jenis_indikator,bobot_kelayakan:this.form.bobot_kelayakan});
      if(d.success){ this.toast('success',d.message||'Berhasil'); this.modal=''; await this.loadStandar(); }
      else this.toast('error',Object.values(d.errors||{}).flat()[0]||d.message||'Gagal');
    },
    async deleteStandar(id) {
      if(!confirm('Yakin hapus standar fasilitas ini?')) return;
      const d = await this.api('DELETE',`/api/standar/${id}`);
      if(d.success){ this.toast('success','Standar dihapus'); await this.loadStandar(); }
    },

    // ════════════════════════════════════════════════════════════════════
    // SLOT WAKTU
    // ════════════════════════════════════════════════════════════════════
    async loadSlot() { const d = await this.api('GET','/api/slot'); if(d && d.success) this.slotList=d.data; else this.toast('error', (d && d.message) || 'Gagal memuat data slot waktu'); },
    async saveSlot() {
      const d = await this.api('POST','/api/slot',{lapangan_id:this.form.lapangan_id,tipe_slot:this.form.tipe_slot,tanggal_mulai:this.form.tanggal_mulai,tanggal_selesai:this.form.tanggal_selesai});
      if(d.success){ this.toast('success',d.message||'Berhasil'); this.modal=''; await this.loadSlot(); }
      else this.toast('error',Object.values(d.errors||{}).flat()[0]||d.message||'Gagal');
    },
    async deleteSlot(id) {
      if(!confirm('Yakin hapus slot waktu ini?')) return;
      const d = await this.api('DELETE',`/api/slot/${id}`);
      if(d.success){ this.toast('success','Slot dihapus'); await this.loadSlot(); }
      else this.toast('error', d.message||'Gagal menghapus slot ini');
    },

    // ════════════════════════════════════════════════════════════════════
    // TARGET KETERISIAN
    // ════════════════════════════════════════════════════════════════════
    async loadTarget() {
      const p = new URLSearchParams(this.targetFilter).toString();
      const d = await this.api('GET','/api/target?'+p); if(d && d.success) this.targetList=d.data; else this.toast('error', (d && d.message) || 'Gagal memuat data target');
    },
    sortTarget(col) { this.targetList.sort((a,b)=>{ const av=col==='nama_lapangan'?(a.lapangan?.nama_lapangan||''):(a[col]||0); const bv=col==='nama_lapangan'?(b.lapangan?.nama_lapangan||''):(b[col]||0); return av>bv?1:av<bv?-1:0; }); },
    async saveTarget() {
      const url = this.editingId ? `/api/target/${this.editingId}` : '/api/target';
      const method = this.editingId ? 'PUT' : 'POST';
      const d = await this.api(method, url, {lapangan_id:this.form.lapangan_id,tahun:this.form.tahun,bulan:this.form.bulan,target_jam:this.form.target_jam,realisasi_jam:this.form.realisasi_jam||0});
      if(d.success){ this.toast('success',d.message||'Berhasil'); this.modal=''; await this.loadTarget(); }
      else this.toast('error',Object.values(d.errors||{}).flat()[0]||d.message||'Gagal');
    },
    editTarget(t) { this.editingId=t.id; this.form={lapangan_id:t.lapangan_id,tahun:t.tahun,bulan:t.bulan,target_jam:t.target_jam,realisasi_jam:t.realisasi_jam}; this.modal='target-edit'; },
    async deleteTarget(id) {
      if(!confirm('Yakin hapus target keterisian ini?')) return;
      const d = await this.api('DELETE',`/api/target/${id}`);
      if(d.success){ this.toast('success','Target dihapus'); await this.loadTarget(); }
      else this.toast('error',d.message||'Gagal');
    },

    // ════════════════════════════════════════════════════════════════════
    // STAF QC
    // ════════════════════════════════════════════════════════════════════
    async loadStafQC() { const d = await this.api('GET','/api/staf-qc'); if(d && d.success) this.stafQCList=d.data; else this.toast('error', (d && d.message) || 'Gagal memuat data staf QC'); },
    async saveStafQC() {
      const url = this.editingId ? `/api/staf-qc/${this.editingId}` : '/api/staf-qc';
      const method = this.editingId ? 'PUT' : 'POST';
      const d = await this.api(method, url, {nik:this.form.nik,nama_staf:this.form.nama_staf,gelar:this.form.gelar,jenis_kelamin:this.form.jenis_kelamin,jabatan:this.form.jabatan,cabang_id:this.form.cabang_id,lapangan_id:this.form.lapangan_id});
      if(d.success){ this.toast('success',d.message||'Berhasil'); this.modal=''; await this.loadStafQC(); }
      else this.toast('error',Object.values(d.errors||{}).flat()[0]||d.message||'Gagal');
    },
    editStafQC(s) { this.editingId=s.id; this.form={nik:s.nik,nama_staf:s.nama_staf,gelar:s.gelar,jenis_kelamin:s.jenis_kelamin,jabatan:s.jabatan,cabang_id:s.cabang_id,lapangan_id:s.lapangan_id}; this.modal='qc-edit'; },
    async deleteStafQC(id) {
      if(!confirm('Yakin hapus staf QC ini?')) return;
      const d = await this.api('DELETE',`/api/staf-qc/${id}`);
      if(d.success){ this.toast('success','Staf dihapus'); await this.loadStafQC(); }
    },

    // ════════════════════════════════════════════════════════════════════
    // KATEGORI TEMUAN
    // ════════════════════════════════════════════════════════════════════
    async loadTemuan() { const d = await this.api('GET','/api/temuan'); if(d && d.success) this.temuanList=d.data; else this.toast('error', (d && d.message) || 'Gagal memuat data temuan'); },
    async saveTemuan() {
      if(this.form.nama_temuan && !this.form.jenis_temuan) this.form.jenis_temuan='Negatif';
      const d = await this.api('POST','/api/temuan',{nama_temuan:this.form.nama_temuan,jenis_temuan:this.form.jenis_temuan});
      if(d.success){ this.toast('success',d.message||'Berhasil'); this.form={jenis_temuan:'Negatif'}; await this.loadTemuan(); }
      else this.toast('error',Object.values(d.errors||{}).flat()[0]||d.message||'Gagal');
    },
    async deleteTemuan(id) {
      if(!confirm('Yakin hapus temuan ini?')) return;
      const d = await this.api('DELETE',`/api/temuan/${id}`);
      if(d.success){ this.toast('success','Temuan dihapus'); await this.loadTemuan(); }
    },

    // ════════════════════════════════════════════════════════════════════
    // REKAP KELAYAKAN
    // ════════════════════════════════════════════════════════════════════
    async loadRekap() {
      const p = new URLSearchParams({search:this.rekapSearch, page:this.rekapPage, per_page:8}).toString();
      const d = await this.api('GET','/api/rekap?'+p);
      if(d && d.success){ this.rekapList=d.data.data||[]; this.rekapTotalPages=Math.max(1, d.data.last_page||1); } else { this.toast('error', (d && d.message) || 'Gagal memuat data rekap'); }
    },
    sortRekap(col) { this.rekapList.sort((a,b)=>{ const av=col==='lapangan'?(a.lapangan?.nama_lapangan||''):(a[col]||0); const bv=col==='lapangan'?(b.lapangan?.nama_lapangan||''):(b[col]||0); return av>bv?1:av<bv?-1:0; }); },
    async saveRekap() {
      const url = this.editingId ? `/api/rekap/${this.editingId}` : '/api/rekap';
      const method = this.editingId ? 'PUT' : 'POST';
      const d = await this.api(method, url, {lapangan_id:this.form.lapangan_id,target_keterisian_jam:this.form.target_keterisian_jam,nilai_kondisi_mandiri:this.form.nilai_kondisi_mandiri,nilai_tim_qc:this.form.nilai_tim_qc,grade:this.form.grade,bintang:this.form.bintang});
      if(d.success){ this.toast('success',d.message||'Berhasil'); this.modal=''; await this.loadRekap(); }
      else this.toast('error',Object.values(d.errors||{}).flat()[0]||d.message||'Gagal');
    },
    editRekap(r) { this.editingId=r.id; this.form={lapangan_id:r.lapangan_id,target_keterisian_jam:r.target_keterisian_jam,nilai_kondisi_mandiri:r.nilai_kondisi_mandiri,nilai_tim_qc:r.nilai_tim_qc,grade:r.grade,bintang:r.bintang}; this.modal='rekap-edit'; },
    async deleteRekap(id) {
      if(!confirm('Yakin hapus rekap kelayakan ini?')) return;
      const d = await this.api('DELETE',`/api/rekap/${id}`);
      if(d.success){ this.toast('success','Rekap dihapus'); await this.loadRekap(); }
      else this.toast('error',d.message||'Gagal');
    },

    // ════════════════════════════════════════════════════════════════════
    // USER MANAGEMENT: MEMBERS
    // ════════════════════════════════════════════════════════════════════
    async loadMembers() { const d = await this.api('GET','/api/users/member'); if(d && d.success) this.memberList=d.data; else this.toast('error', (d && d.message) || 'Gagal memuat data member'); },
    async saveMember() {
      const url = this.editingId ? `/api/users/member/${this.editingId}` : '/api/users/member';
      const method = this.editingId ? 'PUT' : 'POST';
      const payload = {name:this.form.name,username:this.form.username,email:this.form.email,member_group_id:this.form.member_group_id,is_active:this.form.is_active};
      if(this.form.password) payload.password=this.form.password;
      const d = await this.api(method, url, payload);
      if(d.success){ this.toast('success',d.message||'Berhasil'); this.modal=''; await this.loadMembers(); }
      else this.toast('error',Object.values(d.errors||{}).flat()[0]||d.message||'Gagal');
    },
    editMember(u) { this.editingId=u.id; this.form={name:u.name,username:u.username,email:u.email,member_group_id:u.member_group_id,is_active:u.is_active}; this.modal='member-edit'; },
    async deleteMember(id) {
      if(!confirm('Yakin hapus member ini?')) return;
      const d = await this.api('DELETE',`/api/users/member/${id}`);
      if(d.success){ this.toast('success','Member dihapus'); await this.loadMembers(); }
    },
    async toggleMember(id) {
      const d = await this.api('POST',`/api/users/member/${id}/toggle`);
      if(d.success){ this.toast('success',d.message); await this.loadMembers(); }
    },

    // ════════════════════════════════════════════════════════════════════
    // USER MANAGEMENT: STAFF
    // ════════════════════════════════════════════════════════════════════
    async loadStaff() { const d = await this.api('GET','/api/users/staff'); if(d && d.success) this.staffList=d.data; else this.toast('error', (d && d.message) || 'Gagal memuat data staf'); },
    async saveStaff() {
      const url = this.editingId ? `/api/users/staff/${this.editingId}` : '/api/users/staff';
      const method = this.editingId ? 'PUT' : 'POST';
      const payload = {name:this.form.name,username:this.form.username,email:this.form.email,role_id:this.form.role_id,cabang_id:this.form.cabang_id||null,is_active:this.form.is_active};
      if(this.form.password) payload.password=this.form.password;
      const d = await this.api(method, url, payload);
      if(d.success){ this.toast('success',d.message||'Berhasil'); this.modal=''; await this.loadStaff(); }
      else this.toast('error',Object.values(d.errors||{}).flat()[0]||d.message||'Gagal');
    },
    editStaff(u) { this.editingId=u.id; this.form={name:u.name,username:u.username,email:u.email,role_id:u.role_id,cabang_id:u.cabang_id,is_active:u.is_active}; this.modal='staff-edit'; },
    async deleteStaff(id) {
      if(!confirm('Yakin hapus staf ini?')) return;
      const d = await this.api('DELETE',`/api/users/staff/${id}`);
      if(d.success){ this.toast('success','Staf dihapus'); await this.loadStaff(); }
    },
  }
}
</script>
</body>
</html>
