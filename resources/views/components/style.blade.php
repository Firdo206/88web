{{-- resources/views/components/styles.blade.php --}}
<style>
/* ============================================================
   BusGo — Global CSS Variables & Base Styles
   ============================================================ */
:root {
    --bg:          #0a0e1a;
    --surface:     #111827;
    --surface2:    #1a2235;
    --surface3:    #243044;
    --accent:      #f97316;
    --accent2:     #fb923c;
    --accent-dim:  rgba(249, 115, 22, 0.15);
    --text:        #f1f5f9;
    --text2:       #94a3b8;
    --text3:       #64748b;
    --border:      rgba(255, 255, 255, 0.07);
    --green:       #22c55e;
    --red:         #ef4444;
    --blue:        #3b82f6;
    --yellow:      #eab308;
    --sidebar-w:   260px;
    --sidebar-col: 72px;
}

* { margin: 0; padding: 0; box-sizing: border-box; }
body { font-family: 'DM Sans', sans-serif; background: var(--bg); color: var(--text); min-height: 100vh; }

/* ── Sidebar ─────────────────────────────────────── */
.sidebar {
    width: var(--sidebar-w);
    background: var(--surface);
    border-right: 1px solid var(--border);
    display: flex;
    flex-direction: column;
    position: fixed;
    top: 0; left: 0;
    height: 100vh;
    z-index: 100;
    transition: width .3s cubic-bezier(.4,0,.2,1);
    overflow: hidden;
}
.sidebar.collapsed { width: var(--sidebar-col); }

.sidebar-header {
    padding: 24px 20px;
    display: flex;
    align-items: center;
    gap: 12px;
    border-bottom: 1px solid var(--border);
    min-height: 72px;
    flex-shrink: 0;
}
.logo-icon {
    width: 36px; height: 36px;
    background: var(--accent);
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    font-size: 18px; flex-shrink: 0;
}
.logo-text {
    font-family: 'Syne', sans-serif;
    font-weight: 800; font-size: 18px;
    white-space: nowrap; overflow: hidden;
}
.logo-text span { color: var(--accent); }

.sidebar-toggle {
    margin-left: auto;
    background: none; border: none;
    color: var(--text2); cursor: pointer;
    padding: 6px; border-radius: 8px;
    display: flex; align-items: center;
    transition: all .2s; flex-shrink: 0;
}
.sidebar-toggle:hover { background: var(--surface3); color: var(--text); }
.sidebar-toggle svg { width: 18px; height: 18px; }

.sidebar-nav { padding: 16px 12px; flex: 1; overflow-y: auto; overflow-x: hidden; }
.nav-section { margin-bottom: 24px; }
.nav-label {
    font-size: 10px; font-weight: 600;
    letter-spacing: 1.5px; color: var(--text3);
    text-transform: uppercase;
    padding: 0 8px; margin-bottom: 8px;
    white-space: nowrap; overflow: hidden;
    transition: opacity .2s;
}
.sidebar.collapsed .nav-label { opacity: 0; }

.nav-item {
    display: flex; align-items: center; gap: 12px;
    padding: 10px 12px; border-radius: 10px;
    cursor: pointer; transition: all .2s;
    color: var(--text2); text-decoration: none;
    margin-bottom: 2px; white-space: nowrap;
    position: relative;
}
.nav-item:hover  { background: var(--surface2); color: var(--text); }
.nav-item.active { background: var(--accent-dim); color: var(--accent); }

.nav-icon { width: 20px; height: 20px; flex-shrink: 0; display: flex; align-items: center; justify-content: center; }
.nav-icon svg { width: 18px; height: 18px; }
.nav-text { font-size: 14px; font-weight: 500; overflow: hidden; transition: opacity .2s; }
.sidebar.collapsed .nav-text { opacity: 0; }

.nav-badge {
    margin-left: auto;
    background: var(--accent); color: #fff;
    font-size: 11px; font-weight: 700;
    padding: 2px 7px; border-radius: 20px;
    transition: opacity .2s; flex-shrink: 0;
}
.sidebar.collapsed .nav-badge { opacity: 0; }

/* Tooltip saat sidebar di-collapse */
.sidebar.collapsed .nav-item::after {
    content: attr(data-tooltip);
    position: absolute;
    left: calc(var(--sidebar-col) + 8px);
    top: 50%; transform: translateY(-50%);
    background: #1e293b; color: var(--text);
    padding: 6px 10px; border-radius: 8px;
    font-size: 13px; white-space: nowrap;
    pointer-events: none; opacity: 0;
    transition: opacity .15s;
    border: 1px solid var(--border); z-index: 200;
}
.sidebar.collapsed .nav-item:hover::after { opacity: 1; }

.sidebar-user {
    padding: 16px 20px;
    border-top: 1px solid var(--border);
    display: flex; align-items: center; gap: 12px;
    overflow: hidden;
}
.sidebar-user-avatar {
    width: 36px; height: 36px; border-radius: 10px;
    background: var(--accent);
    display: flex; align-items: center; justify-content: center;
    font-weight: 700; font-size: 14px; flex-shrink: 0;
}
.sidebar-user-info { overflow: hidden; }
.sidebar-user-name { font-size: 14px; font-weight: 600; white-space: nowrap; }
.sidebar-user-role { font-size: 12px; color: var(--text3); white-space: nowrap; }
.sidebar.collapsed .sidebar-user-info { opacity: 0; }

/* ── Main Content ─────────────────────────────────── */
.main {
    margin-left: var(--sidebar-w);
    flex: 1;
    transition: margin-left .3s cubic-bezier(.4,0,.2,1);
    min-height: 100vh;
    display: flex; flex-direction: column;
}
.main.collapsed { margin-left: var(--sidebar-col); }

/* ── Topbar ───────────────────────────────────────── */
.topbar {
    background: var(--surface);
    border-bottom: 1px solid var(--border);
    padding: 0 28px; height: 64px;
    display: flex; align-items: center; gap: 16px;
    position: sticky; top: 0; z-index: 50;
}
.topbar-title { font-family: 'Syne', sans-serif; font-size: 18px; font-weight: 700; }
.topbar-title span { color: var(--text3); font-weight: 400; font-size: 14px; margin-left: 8px; font-family: 'DM Sans', sans-serif; }
.topbar-right { margin-left: auto; display: flex; align-items: center; gap: 12px; }
.topbar-avatar { width: 36px; height: 36px; border-radius: 10px; background: var(--accent); display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 14px; }

/* ── Content Wrapper ──────────────────────────────── */
.content { padding: 28px; flex: 1; }

/* ── Stats Grid ───────────────────────────────────── */
.stats-grid { display: grid; grid-template-columns: repeat(4,1fr); gap: 16px; margin-bottom: 28px; }
.stat-card {
    background: var(--surface); border: 1px solid var(--border);
    border-radius: 16px; padding: 20px;
    position: relative; overflow: hidden;
    transition: transform .2s;
}
.stat-card:hover { transform: translateY(-2px); }
.stat-card::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px; }
.stat-card.orange::before { background: var(--accent); }
.stat-card.green::before  { background: var(--green); }
.stat-card.blue::before   { background: var(--blue); }
.stat-card.yellow::before { background: var(--yellow); }
.stat-icon { width: 42px; height: 42px; border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-bottom: 14px; font-size: 20px; }
.stat-icon.orange { background: rgba(249,115,22,.15); }
.stat-icon.green  { background: rgba(34,197,94,.15); }
.stat-icon.blue   { background: rgba(59,130,246,.15); }
.stat-icon.yellow { background: rgba(234,179,8,.15); }
.stat-value { font-family: 'Syne', sans-serif; font-size: 26px; font-weight: 800; margin-bottom: 4px; }
.stat-label { font-size: 13px; color: var(--text2); }
.stat-change { font-size: 12px; margin-top: 8px; }
.stat-change.up   { color: var(--green); }
.stat-change.down { color: var(--red); }

/* ── Cards ────────────────────────────────────────── */
.card { background: var(--surface); border: 1px solid var(--border); border-radius: 16px; overflow: hidden; }
.card-header { padding: 18px 22px; border-bottom: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; }
.card-title { font-family: 'Syne', sans-serif; font-size: 15px; font-weight: 700; }
.card-body { padding: 22px; }

/* ── Buttons ──────────────────────────────────────── */
.btn {
    display: inline-flex; align-items: center; gap: 8px;
    padding: 10px 18px; border-radius: 10px; border: none;
    cursor: pointer; font-family: 'DM Sans', sans-serif;
    font-size: 13px; font-weight: 600;
    transition: all .2s; text-decoration: none;
}
.btn-primary  { background: var(--accent); color: #fff; }
.btn-primary:hover { background: var(--accent2); transform: translateY(-1px); }
.btn-ghost    { background: var(--surface2); color: var(--text2); border: 1px solid var(--border); }
.btn-ghost:hover { background: var(--surface3); color: var(--text); }
.btn-success  { background: rgba(34,197,94,.15); color: var(--green); border: 1px solid rgba(34,197,94,.25); }
.btn-success:hover { background: rgba(34,197,94,.25); }
.btn-danger   { background: rgba(239,68,68,.15); color: var(--red); border: 1px solid rgba(239,68,68,.25); }
.btn-danger:hover { background: rgba(239,68,68,.25); }
.btn-warning  { background: rgba(234,179,8,.15); color: var(--yellow); border: 1px solid rgba(234,179,8,.25); }
.btn-warning:hover { background: rgba(234,179,8,.25); }
.btn-sm { padding: 6px 12px; font-size: 12px; }

/* ── Tables ───────────────────────────────────────── */
.table-wrap { overflow-x: auto; }
table { width: 100%; border-collapse: collapse; }
th {
    text-align: left; padding: 12px 16px;
    font-size: 11px; font-weight: 700;
    letter-spacing: .8px; text-transform: uppercase;
    color: var(--text3); border-bottom: 1px solid var(--border);
    white-space: nowrap;
}
td { padding: 14px 16px; font-size: 14px; border-bottom: 1px solid var(--border); }
tr:last-child td { border-bottom: none; }
tr:hover td { background: rgba(255,255,255,.02); }

/* ── Badges ───────────────────────────────────────── */
.badge {
    display: inline-flex; align-items: center; gap: 5px;
    padding: 4px 10px; border-radius: 20px;
    font-size: 12px; font-weight: 600;
}
.badge::before { content: ''; width: 6px; height: 6px; border-radius: 50%; }
.badge-success { background: rgba(34,197,94,.12);  color: var(--green);  } .badge-success::before { background: var(--green); }
.badge-warning { background: rgba(234,179,8,.12);  color: var(--yellow); } .badge-warning::before { background: var(--yellow); }
.badge-danger  { background: rgba(239,68,68,.12);  color: var(--red);    } .badge-danger::before  { background: var(--red); }
.badge-blue    { background: rgba(59,130,246,.12); color: var(--blue);   } .badge-blue::before    { background: var(--blue); }
.badge-gray    { background: rgba(148,163,184,.12);color: var(--text2);  } .badge-gray::before    { background: var(--text2); }

/* ── Forms ────────────────────────────────────────── */
.form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
.form-group { display: flex; flex-direction: column; gap: 6px; }
.form-group.full { grid-column: 1 / -1; }
label { font-size: 13px; font-weight: 600; color: var(--text2); }
input, select, textarea {
    background: var(--surface2); border: 1px solid var(--border);
    border-radius: 10px; padding: 10px 14px;
    color: var(--text); font-family: 'DM Sans', sans-serif;
    font-size: 14px; outline: none;
    transition: border-color .2s; width: 100%;
}
input:focus, select:focus, textarea:focus {
    border-color: var(--accent);
    box-shadow: 0 0 0 3px var(--accent-dim);
}
select option { background: var(--surface); }
textarea { resize: vertical; min-height: 90px; }

/* ── Alerts ───────────────────────────────────────── */
.alert {
    padding: 14px 18px; border-radius: 12px;
    margin-bottom: 20px; font-size: 14px;
    display: flex; align-items: center; gap: 10px;
}
.alert-success { background: rgba(34,197,94,.12);  border: 1px solid rgba(34,197,94,.25);  color: var(--green); }
.alert-error   { background: rgba(239,68,68,.12);  border: 1px solid rgba(239,68,68,.25);  color: var(--red); }

/* ── Modal ────────────────────────────────────────── */
.modal-overlay {
    display: none; position: fixed; inset: 0;
    background: rgba(0,0,0,.6); backdrop-filter: blur(4px);
    z-index: 500; align-items: center; justify-content: center;
}
.modal-overlay.open { display: flex; animation: fadeIn .2s; }
.modal {
    background: var(--surface); border: 1px solid var(--border);
    border-radius: 20px; width: 100%; max-width: 560px;
    max-height: 90vh; overflow-y: auto;
    box-shadow: 0 24px 80px rgba(0,0,0,.5);
}
.modal-header {
    padding: 22px 24px; border-bottom: 1px solid var(--border);
    display: flex; align-items: center; justify-content: space-between;
}
.modal-title { font-family: 'Syne', sans-serif; font-size: 17px; font-weight: 700; }
.modal-close {
    background: var(--surface2); border: none; color: var(--text2);
    cursor: pointer; width: 32px; height: 32px; border-radius: 8px;
    display: flex; align-items: center; justify-content: center;
    transition: all .2s; font-size: 18px;
}
.modal-close:hover { background: var(--surface3); color: var(--text); }
.modal-body   { padding: 24px; }
.modal-footer { padding: 18px 24px; border-top: 1px solid var(--border); display: flex; justify-content: flex-end; gap: 10px; }

/* ── Bus Grid ─────────────────────────────────────── */
.bus-grid { display: grid; grid-template-columns: repeat(3,1fr); gap: 16px; }
.bus-card {
    background: var(--surface); border: 1px solid var(--border);
    border-radius: 16px; overflow: hidden;
    transition: all .3s; position: relative;
}
.bus-card:hover { transform: translateY(-4px); border-color: var(--accent); box-shadow: 0 12px 32px rgba(249,115,22,.15); }
.bus-card-img {
    height: 120px;
    background: linear-gradient(135deg, var(--surface2), var(--surface3));
    display: flex; align-items: center; justify-content: center;
    font-size: 48px; position: relative;
}
.bus-card-promo { position: absolute; top: 10px; right: 10px; background: var(--accent); color: #fff; font-size: 11px; font-weight: 700; padding: 3px 8px; border-radius: 6px; }
.bus-card-body  { padding: 16px; }
.bus-card-name  { font-family: 'Syne', sans-serif; font-size: 15px; font-weight: 700; margin-bottom: 4px; }
.bus-card-footer { padding: 12px 16px; border-top: 1px solid var(--border); display: flex; justify-content: space-between; align-items: center; }
.bus-price { font-family: 'Syne', sans-serif; font-weight: 800; color: var(--accent); font-size: 16px; }

/* ── Layout Utilities ─────────────────────────────── */
.grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
.flex   { display: flex; }
.items-center    { align-items: center; }
.justify-between { justify-content: space-between; }
.gap-2 { gap: 8px; }
.mb-4  { margin-bottom: 16px; }
.mb-6  { margin-bottom: 24px; }
.text-sm   { font-size: 13px; }
.text-muted { color: var(--text2); }

.empty-state { text-align: center; padding: 48px 20px; color: var(--text2); }
.empty-state-icon { font-size: 48px; margin-bottom: 12px; opacity: .5; }

@keyframes fadeIn { from { opacity: 0; transform: translateY(8px); } to { opacity: 1; transform: translateY(0); } }

/* ── Scrollbar ────────────────────────────────────── */
::-webkit-scrollbar { width: 6px; height: 6px; }
::-webkit-scrollbar-track { background: transparent; }
::-webkit-scrollbar-thumb { background: var(--surface3); border-radius: 3px; }

/* ── Responsive ───────────────────────────────────── */
@media (max-width: 900px) {
    .stats-grid { grid-template-columns: repeat(2,1fr); }
    .bus-grid   { grid-template-columns: repeat(2,1fr); }
    .form-grid  { grid-template-columns: 1fr; }
    .form-group.full { grid-column: 1; }
}
@media (max-width: 600px) {
    .stats-grid { grid-template-columns: 1fr; }
    .bus-grid   { grid-template-columns: 1fr; }
    .grid-2     { grid-template-columns: 1fr; }
}
</style>