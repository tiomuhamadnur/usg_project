@extends('layouts.base')

@section('header')
    <title>Admin | Whatsapp Gateway</title>
@endsection

@section('content')
    <div class="content">
        <div class="block block-rounded shadow-sm">
            <div class="block-header block-header-default">
                <h3 class="fs-3 fw-semibold mb-0">
                    Whatsapp Gateway Connection
                </h3>
            </div>

            <div class="block-content block-content-full">
                <div class="row gx-4 gy-4 align-items-center">
                    {{-- LEFT: QR --}}
                    <div class="col-md-6 text-center">
                        <div class="p-3 rounded-3 border bg-body-secondary">
                            <div class="mb-3">
                                <h5 class="fw-semibold mb-1">Scan QR to connect</h5>
                                <p class="text-muted mb-0">
                                    Arahkan kamera WhatsApp ke QR ini untuk login.
                                </p>
                            </div>

                            <div id="qr-wrapper" class="d-flex justify-content-center">
                                <img id="qr-image" src="" alt="QR Code" class="img-fluid border rounded-3"
                                    style="max-width: 320px; display:none;">
                            </div>

                            <div id="qr-placeholder" class="text-center mt-3">
                                <span class="text-muted">
                                    QR belum dimuat. Klik <b>Refresh QR</b> untuk mencoba lagi.
                                </span>
                            </div>

                            <div class="mt-3 text-muted">
                                <small>
                                    Last updated: <span id="last-updated">-</span>
                                </small>
                            </div>
                        </div>
                    </div>

                    {{-- RIGHT: Status & Actions --}}
                    <div class="col-md-6">
                        <div class="p-3 rounded-3 border bg-body-secondary h-100 d-flex flex-column">
                            {{-- STATUS --}}
                            <div class="mb-4">
                                <h5 class="fw-semibold mb-2">Status</h5>
                                <div id="wa-status" class="d-flex align-items-center gap-2">
                                    <span class="badge bg-secondary fs-6">Not Connected</span>
                                    <small id="wa-status-desc" class="text-muted">
                                        Menunggu koneksi WhatsApp.
                                    </small>
                                </div>
                            </div>

                            {{-- ACTION --}}
                            <div class="mb-4">
                                <h5 class="fw-semibold mb-2">Actions</h5>

                                <div class="d-flex flex-column gap-2">
                                    <button class="btn btn-primary d-flex align-items-center justify-content-center"
                                        id="btn-refresh">
                                        <i class="fa fa-qrcode me-2"></i>
                                        <span id="refresh-text">Refresh QR</span>
                                        <span id="refresh-spinner" class="spinner-border spinner-border-sm ms-2"
                                            style="display:none;"></span>
                                    </button>

                                    <button class="btn btn-outline-danger d-flex align-items-center justify-content-center"
                                        id="btn-disconnect">
                                        <i class="fa fa-plug-circle-xmark me-2"></i>
                                        <span id="disconnect-text">Disconnect</span>
                                        <span id="disconnect-spinner" class="spinner-border spinner-border-sm ms-2"
                                            style="display:none;"></span>
                                    </button>

                                    <button
                                        class="btn btn-outline-secondary d-flex align-items-center justify-content-center"
                                        id="btn-auto-refresh">
                                        <i class="fa fa-clock-rotate-left me-2"></i>
                                        <span id="auto-refresh-text">Auto Refresh: OFF</span>
                                    </button>

                                    <div class="text-muted mt-2">
                                        <small>
                                            Auto refresh akan memuat QR setiap <b>30 detik</b>.
                                        </small>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-auto">
                                <div class="alert alert-info mb-0" role="alert">
                                    <strong>Tip:</strong> Jika status connected, QR akan hilang.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Toast Notification --}}
        <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 9999">
            <div id="toast-container"></div>
        </div>
    </div>
@endsection

@section('javascript')
    <script>
        const BASE_URL = "{{ config('services.whatsapp.url') }}";
        const QR_ENDPOINT = BASE_URL + "/qr";
        const DISCONNECT_ENDPOINT = BASE_URL + "/disconnect";

        const qrImage = document.getElementById('qr-image');
        const qrPlaceholder = document.getElementById('qr-placeholder');

        const statusEl = document.getElementById('wa-status');
        const statusDesc = document.getElementById('wa-status-desc');
        const lastUpdatedEl = document.getElementById('last-updated');

        const refreshBtn = document.getElementById('btn-refresh');
        const disconnectBtn = document.getElementById('btn-disconnect');
        const autoRefreshBtn = document.getElementById('btn-auto-refresh');

        const refreshSpinner = document.getElementById('refresh-spinner');
        const disconnectSpinner = document.getElementById('disconnect-spinner');

        let autoRefresh = false;
        let autoRefreshInterval = null;
        let statusInterval = null;

        function showToast(title, message, type = 'info') {
            const toastId = 'toast-' + Date.now();
            const toastHtml = `
            <div id="${toastId}" class="toast align-items-center text-bg-${type} border-0 mb-2" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        <strong>${title}</strong><br>
                        ${message}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        `;

            document.getElementById('toast-container').insertAdjacentHTML('beforeend', toastHtml);
            const toastEl = document.getElementById(toastId);
            const bsToast = new bootstrap.Toast(toastEl, {
                delay: 4000
            });
            bsToast.show();

            toastEl.addEventListener('hidden.bs.toast', () => toastEl.remove());
        }

        function setStatus(type, desc) {
            let badgeClass = 'bg-secondary';
            let text = 'Not Connected';

            if (type === 'qr') {
                badgeClass = 'bg-warning';
                text = 'QR Ready';
            } else if (type === 'connected') {
                badgeClass = 'bg-success';
                text = 'Connected';
            } else if (type === 'disconnected') {
                badgeClass = 'bg-secondary';
                text = 'Disconnected';
            } else if (type === 'failed') {
                badgeClass = 'bg-danger';
                text = 'Failed';
            }

            statusEl.innerHTML = `<span class="badge ${badgeClass} fs-6">${text}</span>`;
            statusDesc.innerText = desc || '';
        }

        function setLastUpdated() {
            const now = new Date();
            lastUpdatedEl.innerText = now.toLocaleString('id-ID', {
                year: 'numeric',
                month: 'short',
                day: '2-digit',
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            });
        }

        async function loadQr() {
            try {
                refreshBtn.disabled = true;
                refreshSpinner.style.display = 'inline-block';

                qrImage.style.display = 'none';
                qrPlaceholder.style.display = 'block';

                setStatus('qr', 'Muat QR...');

                const res = await fetch(QR_ENDPOINT);
                if (!res.ok) throw new Error('Failed to get QR');

                const data = await res.json();

                if (data.status === 'connected') {
                    setStatus('connected', 'WhatsApp sudah terhubung.');
                    qrPlaceholder.innerHTML =
                    `<span class="text-muted">WhatsApp connected. QR tidak diperlukan.</span>`;
                    qrPlaceholder.style.display = 'block';
                    qrImage.style.display = 'none';
                    setLastUpdated();
                    return;
                }

                if (data.status !== 'qr' || !data.qr) {
                    throw new Error('QR not found');
                }

                qrImage.src = data.qr;
                qrImage.style.display = 'block';
                qrPlaceholder.style.display = 'none';

                setStatus('qr', 'Scan QR ini untuk connect.');
                setLastUpdated();

                showToast('QR Loaded', 'QR berhasil dimuat.', 'success');
            } catch (err) {
                console.error(err);
                setStatus('failed', 'Gagal memuat QR. Coba klik Refresh.');
                showToast('Error', err.message, 'danger');
            } finally {
                refreshBtn.disabled = false;
                refreshSpinner.style.display = 'none';
            }
        }

        async function checkStatusOnly() {
            try {
                const res = await fetch(QR_ENDPOINT);
                if (!res.ok) return;

                const data = await res.json();

                if (data.status === 'connected') {
                    setStatus('connected', 'WhatsApp sudah terhubung.');
                    qrImage.style.display = 'none';
                    qrPlaceholder.innerHTML =
                    `<span class="text-muted">WhatsApp connected. QR tidak diperlukan.</span>`;
                    qrPlaceholder.style.display = 'block';
                    setLastUpdated();
                }
            } catch (err) {
                console.error(err);
            }
        }

        async function disconnectWa() {
            try {
                disconnectBtn.disabled = true;
                disconnectSpinner.style.display = 'inline-block';

                setStatus('disconnected', 'Disconnect in progress...');

                const res = await fetch(DISCONNECT_ENDPOINT, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                });

                if (!res.ok) throw new Error('Disconnect failed');

                const data = await res.json();

                if (data.success) {
                    setStatus('disconnected', 'Disconnected. QR baru siap.');
                    showToast('Disconnected', data.message, 'success');
                    loadQr();
                } else {
                    throw new Error(data.message || 'Disconnect failed');
                }

            } catch (err) {
                alert('Gagal disconnect WhatsApp: ' + err.message);
                console.error(err);
                setStatus('failed', 'Disconnect gagal. Coba lagi.');
                showToast('Error', err.message, 'danger');
            } finally {
                disconnectBtn.disabled = false;
                disconnectSpinner.style.display = 'none';
            }
        }

        function toggleAutoRefresh() {
            autoRefresh = !autoRefresh;

            if (autoRefresh) {
                autoRefreshBtn.classList.remove('btn-outline-secondary');
                autoRefreshBtn.classList.add('btn-secondary');
                autoRefreshBtn.innerHTML =
                    `<i class="fa fa-clock-rotate-left me-2"></i><span id="auto-refresh-text">Auto Refresh: ON</span>`;

                autoRefreshInterval = setInterval(() => {
                    loadQr();
                }, 30000); // 30 detik

                showToast('Auto Refresh', 'Auto refresh QR diaktifkan (30 detik).', 'info');
            } else {
                autoRefreshBtn.classList.remove('btn-secondary');
                autoRefreshBtn.classList.add('btn-outline-secondary');
                autoRefreshBtn.innerHTML =
                    `<i class="fa fa-clock-rotate-left me-2"></i><span id="auto-refresh-text">Auto Refresh: OFF</span>`;

                clearInterval(autoRefreshInterval);
                autoRefreshInterval = null;
                showToast('Auto Refresh', 'Auto refresh QR dimatikan.', 'info');
            }
        }

        refreshBtn.addEventListener('click', loadQr);
        disconnectBtn.addEventListener('click', disconnectWa);
        autoRefreshBtn.addEventListener('click', toggleAutoRefresh);

        // Auto status check every 5 seconds
        statusInterval = setInterval(() => {
            checkStatusOnly();
        }, 5000);

        // Load QR initially
        loadQr();
    </script>
@endsection
