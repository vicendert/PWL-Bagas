<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="Sistem Manajemen Sewa Lapangan Olahraga — Platform terintegrasi untuk mengelola reservasi, fasilitas, dan kualitas lapangan.">
<title>SportSpace — Manajemen Sewa Lapangan</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
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

/* ── Toast ── */
.toast-container { position: fixed; top: 20px; right: 20px; z-index: 9999; display: flex; flex-direction: column; gap: 8px; }
.toast {
  display: flex; align-items: center; gap: 10px; padding: 14px 18px;
  border-radius: 12px; box-shadow: 0 8px 24px rgba(0,0,0,.15);
  font-size: 14px; font-weight: 500; min-width: 260px; max-width: 380px;
  animation: toastIn .3s ease-out;
  transition: all .3s;
}
@keyframes toastIn { from { opacity: 0; transform: translateX(20px); } }
.toast.success { background: #f0fdf4; border: 1px solid #bbf7d0; color: #15803d; }
.toast.error   { background: #fef2f2; border: 1px solid #fecaca; color: #b91c1c; }
.toast.warning { background: #fffbeb; border: 1px solid #fed7aa; color: #b45309; }

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
</style>
</head>
<body>
<div id="app" x-data="sportsApp()" x-init="init()">

  <!-- ▓▓▓ TOAST NOTIFICATIONS ▓▓▓ -->
  <div class="toast-container">
    <template x-for="(t, i) in toasts" :key="i">
      <div class="toast" :class="t.type" x-show="t.visible" x-transition>
        <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
          <path x-show="t.type==='success'" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
          <path x-show="t.type==='error'" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
          <path x-show="t.type==='warning'" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
        </svg>
        <span x-text="t.msg"></span>
      </div>
    </template>
  </div>

  <!-- ▓▓▓ LOGIN PAGE ▓▓▓ -->
  <div class="login-wrap" x-show="!isAuth" x-transition>
    <div class="login-bg-orb" style="width:400px;height:400px;background:#6366f1;top:-100px;left:-100px;"></div>
    <div class="login-bg-orb" style="width:300px;height:300px;background:#06b6d4;bottom:-80px;right:-60px;"></div>
    <div class="login-bg-orb" style="width:200px;height:200px;background:#8b5cf6;top:40%;right:15%;"></div>

    <div class="login-card">
      <div class="login-logo">
        <div class="login-logo-icon">
          <svg width="32" height="32" viewBox="0 0 24 24" fill="white">
            <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
          </svg>
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

      <p style="text-align:center;margin-top:24px;font-size:12px;color:rgba(255,255,255,.3);">
        © 2026 SportSpace · Sistem Manajemen Lapangan
      </p>
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
          <div class="sb-item" :class="{active: page==='dashboard'}" @click="page='dashboard'; loadDashboard()">
            <svg class="sb-item-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
            <span class="sb-item-label" x-show="!sidebarCollapsed">Dashboard</span>
          </div>
          <div class="sb-item" :class="{active: page==='beranda'}" @click="page='beranda'">
            <svg class="sb-item-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/></svg>
            <span class="sb-item-label" x-show="!sidebarCollapsed">Sewa Lapangan</span>
          </div>
          <div class="sb-item" :class="{active: page==='alamat'}" @click="page='alamat'">
            <svg class="sb-item-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg>
            <span class="sb-item-label" x-show="!sidebarCollapsed">Alamat</span>
          </div>
          <div class="sb-item" :class="{active: page==='about'}" @click="page='about'">
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
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                Unduh Chart
              </button>
            </div>
            <div class="card-body">
              <div class="chart-area">
                <canvas id="occupancyChart"></canvas>
              </div>
            </div>
          </div>
        </div>

        <!-- ══ BERANDA / SEWA LAPANGAN ══ -->
        <div x-show="page==='beranda'">
          <div class="breadcrumb"><span>Sewa Lapangan</span></div>
          <div class="card">
            <div class="card-header"><div class="card-title">🏟️ Daftar Lapangan Tersedia</div></div>
            <div class="card-body">
              <div class="stats-grid" style="grid-template-columns:repeat(auto-fill,minmax(260px,1fr))">
                <template x-for="l in lookups.lapangan" :key="l.id">
                  <div class="stat-card" style="cursor:default">
                    <div class="stat-icon blue" style="margin-bottom:12px">
                      <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 21V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v16"/></svg>
                    </div>
                    <div style="font-size:15px;font-weight:700;margin-bottom:4px" x-text="l.nama_lapangan"></div>
                    <div style="font-size:12px;color:var(--text-muted)" x-text="l.kode"></div>
                    <div style="margin-top:10px;display:flex;gap:6px;flex-wrap:wrap">
                      <span class="badge badge-info" x-text="l.kategori_lapangan ? l.kategori_lapangan.nama_kategori : '—'"></span>
                      <span class="badge badge-purple" x-text="l.akreditasi"></span>
                    </div>
                    <div style="font-size:12px;color:var(--text-muted);margin-top:8px" x-text="l.cabang ? l.cabang.nama_cabang : ''"></div>
                  </div>
                </template>
              </div>
            </div>
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
                <div class="field-group"><label class="field-label">Deskripsi</label><textarea class="field-textarea" x-model="form.deskripsi" placeholder="Deskripsi singkat hub..."></textarea></div>
              </div>
              <div class="modal-footer">
                <button class="btn btn-secondary" @click="modal=''">Batal</button>
                <button class="btn btn-primary" @click="saveHub">Simpan</button>
              </div>
            </div>
          </div>
        </div>

        <!-- ══ DATA LAPANGAN ══ -->
        <div x-show="page==='lapangan'">
          <div class="breadcrumb"><span>Data Detail Lapangan</span></div>
          <div class="card">
            <div class="card-header">
              <div class="card-title">🏟️ Daftar Lapangan</div>
              <button class="btn btn-primary btn-sm" @click="openModal('lap-add')">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Tambah Lapangan
              </button>
            </div>
            <div class="table-wrap">
              <table>
                <thead><tr><th>No</th><th>Kode</th><th>Nama Lapangan</th><th>Kategori</th><th>Hub</th><th>Akreditasi</th><th>Cabang</th><th>Aksi</th></tr></thead>
                <tbody>
                  <template x-for="(l,i) in lapanganList" :key="l.id">
                    <tr>
                      <td x-text="i+1"></td>
                      <td><code style="font-size:12px;background:#f1f5f9;padding:2px 6px;border-radius:4px" x-text="l.kode"></code></td>
                      <td><strong x-text="l.nama_lapangan"></strong></td>
                      <td><span class="badge badge-info" x-text="l.kategori_lapangan ? l.kategori_lapangan.nama_kategori : '—'"></span></td>
                      <td x-text="l.hub_pusat ? l.hub_pusat.nama_hub : '—'"></td>
                      <td><span class="badge badge-purple" x-text="l.akreditasi"></span></td>
                      <td x-text="l.cabang ? l.cabang.nama_cabang : '—'"></td>
                      <td><div class="action-btns">
                        <button class="btn-icon edit" @click="editLapangan(l)">✏️</button>
                        <button class="btn-icon delete" @click="deleteLapangan(l.id)">🗑️</button>
                      </div></td>
                    </tr>
                  </template>
                  <tr x-show="lapanganList.length===0"><td colspan="8" class="empty-state"><p>Belum ada data lapangan</p></td></tr>
                </tbody>
              </table>
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
              </div>
              <div class="modal-footer">
                <button class="btn btn-secondary" @click="modal=''">Batal</button>
                <button class="btn btn-primary" @click="saveLapangan">Simpan</button>
              </div>
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
                        <button class="btn-icon delete" @click="deleteSarana(s.id)">🗑️</button>
                      </div></td>
                    </tr>
                  </template>
                  <tr x-show="saranaList.length===0"><td colspan="6" class="empty-state"><p>Belum ada data sarana</p></td></tr>
                </tbody>
              </table>
            </div>
          </div>

          <div class="modal-overlay" x-show="modal==='sarana-add'" @click.self="modal=''">
            <div class="modal">
              <div class="modal-header">
                <div class="modal-title">Tambah Sarana Fasilitas</div>
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
                        <td><span class="badge" :class="t.deskripsi_skema_jam.includes('Pagi')?'badge-warning':'badge-info'" x-text="t.deskripsi_skema_jam"></span></td>
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
                </tr></thead>
                <tbody>
                  <template x-for="(t,i) in targetList" :key="t.id">
                    <tr>
                      <td x-text="i+1"></td>
                      <td x-text="t.lapangan ? t.lapangan.nama_lapangan : '—'"></td>
                      <td x-text="['','Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'][t.bulan] + ' ' + t.tahun"></td>
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
                    </tr>
                  </template>
                  <tr x-show="targetList.length===0"><td colspan="7" class="empty-state"><p>Belum ada data target</p></td></tr>
                </tbody>
              </table>
            </div>
          </div>

          <div class="modal-overlay" x-show="modal==='target-add'" @click.self="modal=''">
            <div class="modal">
              <div class="modal-header"><div class="modal-title">Tambah Target Keterisian</div><button class="modal-close" @click="modal=''">✕</button></div>
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
                      <td><button class="btn-icon delete" @click="deleteStafQC(s.id)">🗑️</button></td>
                    </tr>
                  </template>
                  <tr x-show="stafQCList.length===0"><td colspan="9" class="empty-state"><p>Belum ada staf QC</p></td></tr>
                </tbody>
              </table>
            </div>
          </div>

          <div class="modal-overlay" x-show="modal==='qc-add'" @click.self="modal=''">
            <div class="modal modal-lg">
              <div class="modal-header"><div class="modal-title">Tambah Staf QC</div><button class="modal-close" @click="modal=''">✕</button></div>
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
                        <div class="stars" x-text="'★'.repeat(r.bintang||0) + '☆'.repeat(5-(r.bintang||0))"></div>
                      </td>
                    </tr>
                  </template>
                  <tr x-show="rekapList.length===0"><td colspan="7" class="empty-state"><p>Belum ada rekap kelayakan</p></td></tr>
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

          <div class="modal-overlay" x-show="modal==='rekap-add'" @click.self="modal=''">
            <div class="modal">
              <div class="modal-header"><div class="modal-title">Tambah Rekap Kelayakan</div><button class="modal-close" @click="modal=''">✕</button></div>
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
    modal: '',
    form: {},
    toasts: [],

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
        const r = await fetch('/api/login', {
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
      await fetch('/api/logout', { method:'POST', headers:{'X-CSRF-TOKEN':'{{ csrf_token() }}','Accept':'application/json'} });
      sessionStorage.removeItem('sportspace_user');
      this.isAuth = false; this.currentUser = null;
      this.loginForm = { username:'', password:'' };
    },

    // ── Lookups ───────────────────────────────────────────────────────────
    async loadLookups() {
      const [cabang, kategori, hub, lapangan, roles, member_groups] = await Promise.all([
        fetch('/api/lookup/cabang').then(r=>r.json()),
        fetch('/api/lookup/kategori').then(r=>r.json()),
        fetch('/api/lookup/hub').then(r=>r.json()),
        fetch('/api/lookup/lapangan').then(r=>r.json()),
        fetch('/api/lookup/roles').then(r=>r.json()),
        fetch('/api/lookup/member-groups').then(r=>r.json()),
      ]);
      this.lookups = { cabang, kategori, hub, lapangan, roles, member_groups };
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
      const loaders = {
        'musim': this.loadMusim, 'mitra': this.loadMitra, 'hub': this.loadHub,
        'lapangan': this.loadLapangan, 'sarana': this.loadSarana,
        'dokumen': this.loadDokumen, 'tarif': ()=>{ this.loadTarif(); this.loadStandar(); },
        'slot': this.loadSlot, 'target': this.loadTarget, 'staf-qc': this.loadStafQC,
        'temuan': this.loadTemuan, 'rekap': this.loadRekap,
        'users-member': this.loadMembers, 'users-staff': this.loadStaff,
        'beranda': this.loadLookups, 'alamat': this.loadLookups
      };
      if (loaders[p]) await loaders[p].call(this);
    },

    // ── Toast ─────────────────────────────────────────────────────────────
    toast(type, msg) {
      const t = { type, msg, visible: true };
      this.toasts.push(t);
      setTimeout(()=>{ t.visible = false; setTimeout(()=>{ this.toasts = this.toasts.filter(x=>x!==t); }, 300); }, 3500);
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

    // ── API helper ────────────────────────────────────────────────────────
    async api(method, url, body = null, isFormData = false) {
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
      const r = await fetch(url, opts);
      return r.json();
    },

    // ════════════════════════════════════════════════════════════════════
    // DASHBOARD
    // ════════════════════════════════════════════════════════════════════
    async loadDashboard() {
      const params = new URLSearchParams(this.dashFilter).toString();
      const d = await this.api('GET', '/api/dashboard?' + params);
      if (d.success) {
        this.dashStats = d.stats;
        this.$nextTick(() => this.renderChart(d.chart_data || []));
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
    async loadMusim() { const d = await this.api('GET','/api/musim'); if(d.success) this.musimList=d.data; },
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
    async loadMitra() { const d = await this.api('GET','/api/mitra'); if(d.success) this.mitraList=d.data; },
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
    async loadHub() { const d = await this.api('GET','/api/hub'); if(d.success) this.hubList=d.data; },
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
    async loadLapangan() { const d = await this.api('GET','/api/lapangan'); if(d.success) this.lapanganList=d.data; },
    async saveLapangan() {
      const fd = new FormData();
      const fields = ['hub_pusat_id','cabang_id','kategori_lapangan_id','kode','nama_lapangan','akreditasi','nomor_sk','tanggal_sertifikasi','alamat'];
      fields.forEach(f => { if(this.form[f] !== undefined && this.form[f] !== null) fd.append(f, this.form[f]); });
      if(this.form.dokumen_legalitas) fd.append('dokumen_legalitas', this.form.dokumen_legalitas);
      if(this.editingId) fd.append('_method','PUT');
      const url = this.editingId ? `/api/lapangan/${this.editingId}` : '/api/lapangan';
      const r = await fetch(url, { method:'POST', headers:{'Accept':'application/json','X-CSRF-TOKEN':'{{ csrf_token() }}'}, body:fd });
      const d = await r.json();
      if(d.success){ this.toast('success',d.message||'Berhasil'); this.modal=''; await this.loadLapangan(); await this.loadLookups(); }
      else this.toast('error', Object.values(d.errors||{}).flat()[0]||d.message||'Gagal');
    },
    editLapangan(l) {
      this.editingId=l.id;
      this.form={hub_pusat_id:l.hub_pusat_id,cabang_id:l.cabang_id,kategori_lapangan_id:l.kategori_lapangan_id,
        kode:l.kode,nama_lapangan:l.nama_lapangan,akreditasi:l.akreditasi,
        nomor_sk:l.nomor_sk,tanggal_sertifikasi:l.tanggal_sertifikasi,alamat:l.alamat};
      this.modal='lap-edit';
    },
    async deleteLapangan(id) {
      if(!confirm('Yakin hapus lapangan ini?')) return;
      const d = await this.api('DELETE',`/api/lapangan/${id}`);
      if(d.success){ this.toast('success','Lapangan dihapus'); await this.loadLapangan(); await this.loadLookups(); }
      else this.toast('error',d.message||'Gagal');
    },

    // ════════════════════════════════════════════════════════════════════
    // SARANA FASILITAS
    // ════════════════════════════════════════════════════════════════════
    async loadSarana() { const d = await this.api('GET','/api/sarana'); if(d.success) this.saranaList=d.data; },
    async saveSarana() {
      const d = await this.api('POST','/api/sarana',{lapangan_id:this.form.lapangan_id,kode_fasilitas:this.form.kode_fasilitas,nama_unit:this.form.nama_unit,alamat:this.form.alamat});
      if(d.success){ this.toast('success',d.message||'Berhasil'); this.modal=''; await this.loadSarana(); }
      else this.toast('error',Object.values(d.errors||{}).flat()[0]||d.message||'Gagal');
    },
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
      const d = await this.api('GET','/api/dokumen?'+p); if(d.success) this.dokumenList=d.data;
    },
    sortDokumen(col) { this.dokumenFilter.sort_by=col; this.dokumenFilter.sort_order = this.dokumenFilter.sort_order==='asc'?'desc':'asc'; this.loadDokumen(); },
    async saveDokumen() {
      const fd = new FormData();
      ['nama_dokumen','tahun','kategori','unit_pengunggah','jabatan_pengunggah'].forEach(f=>{ if(this.form[f]) fd.append(f,this.form[f]); });
      if(this.form.file_dokumen) fd.append('file_dokumen',this.form.file_dokumen);
      const r = await fetch('/api/dokumen',{method:'POST',headers:{'Accept':'application/json','X-CSRF-TOKEN':'{{ csrf_token() }}'},body:fd});
      const d = await r.json();
      if(d.success){ this.toast('success',d.message||'Berhasil'); this.modal=''; await this.loadDokumen(); }
      else this.toast('error',Object.values(d.errors||{}).flat()[0]||d.message||'Gagal');
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
      const d = await this.api('GET','/api/tarif?'+p); if(d.success) this.tarifList=d.data;
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
      if(d.success) this.standarList = d.data.map(p=>({...p, _open:false}));
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
    async loadSlot() { const d = await this.api('GET','/api/slot'); if(d.success) this.slotList=d.data; },
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
      const d = await this.api('GET','/api/target?'+p); if(d.success) this.targetList=d.data;
    },
    sortTarget(col) { /* client-side sort */ this.targetList.sort((a,b)=>{ const av=col==='nama_lapangan'?(a.lapangan?.nama_lapangan||''):(a[col]||0); const bv=col==='nama_lapangan'?(b.lapangan?.nama_lapangan||''):(b[col]||0); return av>bv?1:av<bv?-1:0; }); },
    async saveTarget() {
      const d = await this.api('POST','/api/target',{lapangan_id:this.form.lapangan_id,tahun:this.form.tahun,bulan:this.form.bulan,target_jam:this.form.target_jam,realisasi_jam:this.form.realisasi_jam||0});
      if(d.success){ this.toast('success',d.message||'Berhasil'); this.modal=''; await this.loadTarget(); }
      else this.toast('error',Object.values(d.errors||{}).flat()[0]||d.message||'Gagal');
    },

    // ════════════════════════════════════════════════════════════════════
    // STAF QC
    // ════════════════════════════════════════════════════════════════════
    async loadStafQC() { const d = await this.api('GET','/api/staf-qc'); if(d.success) this.stafQCList=d.data; },
    async saveStafQC() {
      const d = await this.api('POST','/api/staf-qc',{nik:this.form.nik,nama_staf:this.form.nama_staf,gelar:this.form.gelar,jenis_kelamin:this.form.jenis_kelamin,jabatan:this.form.jabatan,cabang_id:this.form.cabang_id,lapangan_id:this.form.lapangan_id});
      if(d.success){ this.toast('success',d.message||'Berhasil'); this.modal=''; await this.loadStafQC(); }
      else this.toast('error',Object.values(d.errors||{}).flat()[0]||d.message||'Gagal');
    },
    async deleteStafQC(id) {
      if(!confirm('Yakin hapus staf QC ini?')) return;
      const d = await this.api('DELETE',`/api/staf-qc/${id}`);
      if(d.success){ this.toast('success','Staf dihapus'); await this.loadStafQC(); }
    },

    // ════════════════════════════════════════════════════════════════════
    // KATEGORI TEMUAN
    // ════════════════════════════════════════════════════════════════════
    async loadTemuan() { const d = await this.api('GET','/api/temuan'); if(d.success) this.temuanList=d.data; },
    async saveTemuan() {
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
      if(d.success){ this.rekapList=d.data.data||[]; this.rekapTotalPages=Math.max(1, d.data.last_page||1); }
    },
    sortRekap(col) { this.rekapList.sort((a,b)=>{ const av=col==='lapangan'?(a.lapangan?.nama_lapangan||''):(a[col]||0); const bv=col==='lapangan'?(b.lapangan?.nama_lapangan||''):(b[col]||0); return av>bv?1:av<bv?-1:0; }); },
    async saveRekap() {
      const d = await this.api('POST','/api/rekap',{lapangan_id:this.form.lapangan_id,target_keterisian_jam:this.form.target_keterisian_jam,nilai_kondisi_mandiri:this.form.nilai_kondisi_mandiri,nilai_tim_qc:this.form.nilai_tim_qc,grade:this.form.grade,bintang:this.form.bintang});
      if(d.success){ this.toast('success',d.message||'Berhasil'); this.modal=''; await this.loadRekap(); }
      else this.toast('error',Object.values(d.errors||{}).flat()[0]||d.message||'Gagal');
    },

    // ════════════════════════════════════════════════════════════════════
    // USER MANAGEMENT: MEMBERS
    // ════════════════════════════════════════════════════════════════════
    async loadMembers() { const d = await this.api('GET','/api/users/member'); if(d.success) this.memberList=d.data; },
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
    async loadStaff() { const d = await this.api('GET','/api/users/staff'); if(d.success) this.staffList=d.data; },
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
