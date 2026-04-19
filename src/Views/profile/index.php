<style>
    .profile-section { background: var(--surface); border-radius: 12px; padding: 1.5rem; margin-bottom: 1.5rem; box-shadow: 0 2px 12px rgba(0,0,0,.07); }
    .profile-section h2 { font-size: 1rem; font-weight: 700; color: var(--text); margin: 0 0 1.25rem; padding-bottom: .75rem; border-bottom: 1px solid var(--border); }
    .name-fields { display: flex; gap: 1rem; }
    .name-fields .pf-group { flex: 1; }
    .pf-group { margin-bottom: .75rem; }
    .pf-group label { display: block; font-size: .8rem; font-weight: 600; color: var(--text-muted); margin-bottom: .3rem; }
    .pf-group input { width: 100%; padding: .5rem .75rem; font-size: .875rem; border: 1px solid var(--border-soft); border-radius: 6px; background: var(--input-bg); color: var(--text); outline: none; }
    .pf-group input:focus { border-color: #6366f1; box-shadow: 0 0 0 3px rgba(99,102,241,.12); }
    .pf-group input.inp-error { border-color: #f87171; }
    .pf-inline-error { font-size: .75rem; color: #ef4444; margin-top: .25rem; display: none; }
    /* Photo section */
    .photo-divider { margin: 1.5rem 0 1rem; padding-top: 1.25rem; border-top: 1px solid var(--border); font-size: .875rem; font-weight: 600; color: var(--text); }
    .photo-editor { display: flex; gap: 1.5rem; align-items: flex-start; flex-wrap: wrap; }
    .avatar-circle { width: 80px; height: 80px; border-radius: 50%; object-fit: cover; display: block; flex-shrink: 0; }
    .avatar-initials-lg { width: 80px; height: 80px; border-radius: 50%; background: linear-gradient(135deg, #6366f1, #8b5cf6); display: flex; align-items: center; justify-content: center; font-size: 1.6rem; font-weight: 700; color: #fff; flex-shrink: 0; }
    .crop-area { flex: 1; min-width: 260px; }
    /* Custom cropper */
    .pcrop-container { position: relative; display: inline-block; line-height: 0; overflow: hidden; border-radius: 8px; }
    .pcrop-canvas { display: block; }
    .pcrop-box { position: absolute; cursor: move; border: 2px solid #6366f1; box-shadow: 0 0 0 9999px rgba(0,0,0,.55); box-sizing: border-box; touch-action: none; }
    html.dark .pcrop-box { box-shadow: 0 0 0 9999px rgba(0,0,0,.7); }
    .pcrop-handle { position: absolute; width: 12px; height: 12px; background: #6366f1; border: 2px solid #fff; border-radius: 3px; box-shadow: 0 1px 4px rgba(0,0,0,.35); touch-action: none; }
    html.dark .pcrop-handle { border-color: var(--surface); }
    .pcrop-handle-nw { top:-6px; left:-6px; cursor:nw-resize; }
    .pcrop-handle-ne { top:-6px; right:-6px; cursor:ne-resize; }
    .pcrop-handle-sw { bottom:-6px; left:-6px; cursor:sw-resize; }
    .pcrop-handle-se { bottom:-6px; right:-6px; cursor:se-resize; }
    .crop-actions { display: flex; gap: .6rem; margin-top: .75rem; flex-wrap: wrap; align-items: center; }
    /* Security */
    .security-list { display: flex; flex-direction: column; gap: .75rem; }
    .security-item { display: flex; align-items: center; justify-content: space-between; padding: .75rem 1rem; border: 1px solid var(--border); border-radius: 8px; gap: 1rem; }
    .security-item-info { display: flex; flex-direction: column; gap: .15rem; min-width: 0; }
    .security-item-label { font-size: .875rem; font-weight: 600; color: var(--text); }
    .security-item-value { font-size: .8rem; color: var(--text-muted); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    /* Popup */
    .pp-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,.45); z-index: 9998; align-items: center; justify-content: center; }
    .pp-overlay.open { display: flex; }
    .pp-box { background: var(--surface); border-radius: 12px; padding: 1.5rem; width: 90%; max-width: 400px; box-shadow: 0 8px 32px rgba(0,0,0,.18); }
    .pp-box h3 { font-size: 1rem; font-weight: 700; margin: 0 0 1rem; color: var(--text); }
    .pp-step { display: none; }
    .pp-step.active { display: block; }
    .pp-hint { font-size: .82rem; color: var(--text-muted); margin-bottom: 1rem; line-height: 1.5; }
    .pp-actions { display: flex; gap: .6rem; justify-content: flex-end; margin-top: 1rem; }
    @media (max-width: 600px) {
        .name-fields { flex-direction: column; gap: .5rem; }
        .photo-editor { flex-direction: column; }
        .security-item { flex-wrap: wrap; }
    }
</style>

<!-- Informations -->
<section class="profile-section">
    <h2><?= __('profile.informations') ?></h2>

    <form method="POST" action="/profile/info" novalidate id="form-info">
        <div class="name-fields">
            <div class="pf-group">
                <label for="first_name"><?= __('profile.first_name') ?> *</label>
                <input type="text" id="first_name" name="first_name"
                       value="<?= htmlspecialchars($user['first_name']) ?>" autocomplete="off">
                <div class="pf-inline-error" id="err-first-name"></div>
            </div>
            <div class="pf-group">
                <label for="last_name"><?= __('profile.last_name') ?> *</label>
                <input type="text" id="last_name" name="last_name"
                       value="<?= htmlspecialchars($user['last_name']) ?>" autocomplete="off">
                <div class="pf-inline-error" id="err-last-name"></div>
            </div>
        </div>
        <button type="submit" class="btn btn-primary"><?= __('common.save') ?></button>
    </form>

    <div class="photo-divider"><?= __('profile.photo') ?></div>
    <div class="photo-editor">
        <!-- Current avatar preview -->
        <div id="avatar-preview">
            <?php if ($user['has_photo']): ?>
                <img src="/profile/photo" alt="<?= __('profile.photo') ?>" class="avatar-circle">
            <?php else: ?>
                <div class="avatar-initials-lg">
                    <?= htmlspecialchars(mb_strtoupper(mb_substr($user['first_name'], 0, 1))) ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="crop-area">
            <!-- Upload prompt (shown only when no photo) -->
            <div id="upload-prompt" style="<?= $user['has_photo'] ? 'display:none' : '' ?>">
                <label for="photo-file-input" class="btn btn-secondary"><?= __('profile.upload_photo') ?></label>
                <div style="font-size:.8rem;color:var(--text-subtle);margin-top:.5rem;"><?= __('profile.photo_hint') ?></div>
            </div>

            <!-- Crop section (shown only when source image is available) -->
            <div id="crop-section" style="<?= $user['has_photo'] ? '' : 'display:none' ?>">
                <div id="cropper-wrap"></div>
                <div class="crop-actions">
                    <label for="photo-file-input" class="btn btn-secondary"><?= __('profile.change_image') ?></label>
                    <button type="button" class="btn btn-primary" id="btn-save-photo"><?= __('profile.save_photo') ?></button>
                    <?php if ($user['has_photo']): ?>
                        <form method="POST" action="/profile/photo/delete" style="margin:0;">
                            <button type="button"
                                    class="btn-icon btn-delete"
                                    style="width:auto;padding:0 .75rem;height:32px;font-size:.8rem;border-radius:6px;"
                                    id="btn-delete-photo">
                                <?= __('profile.delete_photo') ?>
                            </button>
                        </form>
                    <?php endif; ?>
                </div>
                <div id="photo-error" style="font-size:.8rem;color:#ef4444;margin-top:.4rem;display:none;"></div>
            </div>

            <input type="file" id="photo-file-input" accept="image/jpeg,image/png,image/webp" style="display:none">
        </div>
    </div>
</section>

<!-- Security -->
<section class="profile-section">
    <h2><?= __('profile.security') ?></h2>
    <div class="security-list">
        <div class="security-item">
            <div class="security-item-info">
                <span class="security-item-label"><?= __('profile.email_address') ?></span>
                <span class="security-item-value" id="current-email-display"><?= htmlspecialchars($user['email']) ?></span>
            </div>
            <button type="button" class="btn btn-secondary" id="btn-open-email"><?= __('profile.change') ?></button>
        </div>
        <div class="security-item">
            <div class="security-item-info">
                <span class="security-item-label"><?= __('profile.password') ?></span>
                <span class="security-item-value">••••••••</span>
            </div>
            <button type="button" class="btn btn-secondary" id="btn-open-password"><?= __('profile.change') ?></button>
        </div>
    </div>
</section>

<!-- Language -->
<section class="profile-section">
    <h2><?= __('profile.language') ?></h2>
    <div style="display:flex;align-items:center;justify-content:space-between;gap:1rem;">
        <div style="font-size:.875rem;color:var(--text-muted);"><?= __('profile.language_desc') ?></div>
        <?php include __DIR__ . '/../layouts/_lang_dropdown.php'; ?>
    </div>
</section>

<!-- Integrations -->
<section class="profile-section">
    <h2><?= __('profile.integrations') ?></h2>
    <div style="display:flex;align-items:center;justify-content:space-between;gap:1rem;flex-wrap:wrap;">
        <div style="display:flex;align-items:center;gap:.75rem;">
            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24">
                <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l3.66-2.84z"/>
                <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
            </svg>
            <div>
                <div style="font-size:.875rem;font-weight:600;color:var(--text);">Google Calendar</div>
                <?php if ($gcalEmail): ?>
                    <div style="font-size:.8rem;color:var(--text-muted);margin-top:.1rem;"><?= htmlspecialchars($gcalEmail) ?></div>
                <?php else: ?>
                    <div style="font-size:.8rem;color:var(--text-muted);margin-top:.1rem;"><?= __('profile.gcal_not_connected') ?></div>
                <?php endif; ?>
            </div>
        </div>

        <?php if ($gcalEmail): ?>
            <form method="POST" action="/planning/google/disconnect" style="margin:0;" id="gcal-disconnect-form">
                <button type="button"
                        style="font-size:.8rem;font-weight:600;padding:.3rem .85rem;border-radius:99px;border:1.5px solid #bbf7d0;background:#f0fdf4;color:#16a34a;cursor:pointer;transition:opacity .15s;"
                        onmouseenter="this.style.opacity='.75'" onmouseleave="this.style.opacity='1'"
                        id="btn-gcal-disconnect">
                    <?= __('profile.connected') ?>
                </button>
            </form>
        <?php else: ?>
            <button type="button"
                    style="font-size:.8rem;font-weight:600;padding:.3rem .85rem;border-radius:99px;border:1.5px solid #fecaca;background:#fff1f2;color:#dc2626;cursor:pointer;transition:opacity .15s;"
                    onmouseenter="this.style.opacity='.75'" onmouseleave="this.style.opacity='1'"
                    onclick="document.getElementById('popup-gcal').classList.add('open')">
                <?= __('profile.disconnected') ?>
            </button>
        <?php endif; ?>
    </div>
</section>

<!-- Popup: Google Calendar connect -->
<div class="pp-overlay" id="popup-gcal">
    <div class="pp-box">
        <h3><?= __('profile.gcal_title') ?></h3>
        <p class="pp-hint"><?= __('profile.gcal_desc') ?></p>
        <div class="pp-actions">
            <button class="btn btn-secondary" onclick="closePopup('popup-gcal')"><?= __('common.cancel') ?></button>
            <a href="/planning/google/connect" class="btn btn-primary"><?= __('profile.connect') ?></a>
        </div>
    </div>
</div>

<!-- Logout -->
<section class="profile-section">
    <h2><?= __('profile.session') ?></h2>
    <div style="display:flex;align-items:center;justify-content:space-between;gap:1rem;">
        <div>
            <div style="font-size:.875rem;font-weight:600;color:var(--text);"><?= __('profile.logout') ?></div>
            <div style="font-size:.8rem;color:var(--text-muted);margin-top:.15rem;"><?= __('profile.logout_desc') ?></div>
        </div>
        <button type="button" class="btn btn-secondary"
                style="color:#ef4444;border-color:#fecaca;"
                id="btn-logout">
            <?= __('profile.logout') ?>
        </button>
    </div>
</section>

<!-- Popup: email change -->
<div class="pp-overlay" id="popup-email">
    <div class="pp-box">
        <h3><?= __('profile.email_popup_title') ?></h3>
        <div class="pp-step active" id="email-step-1">
            <div class="pf-group">
                <label><?= __('profile.current_email') ?> *</label>
                <input type="email" id="email-current" autocomplete="off">
                <div class="pf-inline-error" id="err-email-current"></div>
            </div>
            <div class="pf-group">
                <label><?= __('profile.new_email') ?> *</label>
                <input type="email" id="email-new" autocomplete="off">
                <div class="pf-inline-error" id="err-email-new"></div>
            </div>
            <div class="pp-actions">
                <button class="btn btn-secondary" onclick="closePopup('popup-email')"><?= __('common.cancel') ?></button>
                <button class="btn btn-primary" id="btn-email-send"><?= __('profile.send_codes') ?></button>
            </div>
        </div>
        <div class="pp-step" id="email-step-2">
            <p class="pp-hint"><?= __('profile.codes_sent') ?></p>
            <div class="pf-group">
                <label><?= __('profile.code_old_email') ?> *</label>
                <input type="text" id="email-code-old" maxlength="6" placeholder="000000" autocomplete="off">
                <div class="pf-inline-error" id="err-code-old"></div>
            </div>
            <div class="pf-group">
                <label><?= __('profile.code_new_email') ?> *</label>
                <input type="text" id="email-code-new" maxlength="6" placeholder="000000" autocomplete="off">
                <div class="pf-inline-error" id="err-code-new"></div>
            </div>
            <div class="pp-actions">
                <button class="btn btn-secondary" onclick="closePopup('popup-email')"><?= __('common.cancel') ?></button>
                <button class="btn btn-primary" id="btn-email-verify"><?= __('profile.confirm') ?></button>
            </div>
        </div>
    </div>
</div>

<!-- Popup: password change -->
<div class="pp-overlay" id="popup-password">
    <div class="pp-box">
        <h3><?= __('profile.pw_popup_title') ?></h3>
        <div class="pf-group">
            <label><?= __('profile.current_password') ?> *</label>
            <input type="password" id="pw-current">
            <div class="pf-inline-error" id="err-pw-current"></div>
        </div>
        <div class="pf-group">
            <label><?= __('profile.new_password') ?> * <span style="font-weight:400;color:var(--text-subtle)"><?= __('profile.pw_hint') ?></span></label>
            <input type="password" id="pw-new">
            <div class="pf-inline-error" id="err-pw-new"></div>
        </div>
        <div class="pf-group">
            <label><?= __('profile.confirm_new_pw') ?> *</label>
            <input type="password" id="pw-confirm">
            <div class="pf-inline-error" id="err-pw-confirm"></div>
        </div>
        <div class="pp-actions">
            <button class="btn btn-secondary" onclick="closePopup('popup-password')"><?= __('common.cancel') ?></button>
            <button class="btn btn-primary" id="btn-pw-save"><?= __('common.save') ?></button>
        </div>
    </div>
</div>

<script>
(function () {
    var LANG = {
        required:        <?= json_encode(__('common.required')) ?>,
        error:           <?= json_encode(__('common.error')) ?>,
        pwTooShort:      <?= json_encode(__('profile.pw_too_short')) ?>,
        pwNoMatch:       <?= json_encode(__('profile.pw_no_match')) ?>,
        saving:          <?= json_encode(__('profile.saving')) ?>,
        sending:         <?= json_encode(__('profile.sending')) ?>,
        verifying:       <?= json_encode(__('profile.verifying')) ?>,
        confirm:         <?= json_encode(__('profile.confirm')) ?>,
        save:            <?= json_encode(__('common.save')) ?>,
        sendCodes:       <?= json_encode(__('profile.send_codes')) ?>,
        savePhoto:       <?= json_encode(__('profile.save_photo')) ?>,
        passwordUpdated: <?= json_encode(__('profile.password_updated')) ?>,
        deletePhotoConfirm: <?= json_encode(__('profile.delete_photo_confirm')) ?>,
        gcalDisconnectConfirm: <?= json_encode(__('profile.gcal_disconnect_confirm')) ?>,
        logoutConfirm:   <?= json_encode(__('profile.logout_confirm')) ?>
    };

    // ── Shared helpers ──────────────────────────────────────────
    window.closePopup = function (id) {
        document.getElementById(id).classList.remove('open');
    };
    document.querySelectorAll('.pp-overlay').forEach(function (el) {
        el.addEventListener('click', function (e) { if (e.target === el) el.classList.remove('open'); });
    });
    function setErr(id, msg) {
        var el = document.getElementById(id);
        if (!el) return;
        el.textContent = msg;
        el.style.display = msg ? 'block' : 'none';
        var inp = el.previousElementSibling;
        if (inp && inp.tagName === 'INPUT') inp.classList.toggle('inp-error', !!msg);
    }

    // ── Name form validation ────────────────────────────────────
    document.getElementById('form-info').addEventListener('submit', function (e) {
        var ok = true;
        [['first_name', 'err-first-name'], ['last_name', 'err-last-name']].forEach(function (p) {
            if (!document.getElementById(p[0]).value.trim()) { setErr(p[1], LANG.required); ok = false; }
            else setErr(p[1], '');
        });
        if (!ok) e.preventDefault();
    });

    // ── Confirm buttons ─────────────────────────────────────────
    var btnDeletePhoto = document.getElementById('btn-delete-photo');
    if (btnDeletePhoto) {
        btnDeletePhoto.addEventListener('click', function () {
            esConfirm(LANG.deletePhotoConfirm, function () {
                btnDeletePhoto.closest('form').submit();
            });
        });
    }
    var btnGcalDisconnect = document.getElementById('btn-gcal-disconnect');
    if (btnGcalDisconnect) {
        btnGcalDisconnect.addEventListener('click', function () {
            esConfirm(LANG.gcalDisconnectConfirm, function () {
                document.getElementById('gcal-disconnect-form').submit();
            });
        });
    }
    document.getElementById('btn-logout').addEventListener('click', function () {
        esConfirm(LANG.logoutConfirm, function () { window.location = '/logout'; });
    });

    // ── Custom crop component ───────────────────────────────────
    function ProfileCropper(wrap) {
        this.wrap   = wrap;
        this.img    = new Image();
        this.scale  = 1;
        this.crop   = { x: 0, y: 0, size: 0 };

        // DOM
        this.container = document.createElement('div');
        this.container.className = 'pcrop-container';

        this.canvas = document.createElement('canvas');
        this.canvas.className = 'pcrop-canvas';

        this.box = document.createElement('div');
        this.box.className = 'pcrop-box';

        var self = this;
        ['nw','ne','sw','se'].forEach(function (p) {
            var h = document.createElement('div');
            h.className = 'pcrop-handle pcrop-handle-' + p;
            h.dataset.corner = p;
            self.box.appendChild(h);
        });

        this.container.appendChild(this.canvas);
        this.container.appendChild(this.box);
        wrap.innerHTML = '';
        wrap.appendChild(this.container);

        this._bindDrag();
        this._bindHandles();
    }

    ProfileCropper.prototype.load = function (src, savedData) {
        var self = this;
        this.img.onload = function () {
            requestAnimationFrame(function () {
                self._render();
                var iw = self.img.naturalWidth, ih = self.img.naturalHeight;
                if (savedData && savedData.size) {
                    var min = Math.min(iw, ih);
                    self.crop = {
                        x:    savedData.x    * iw,
                        y:    savedData.y    * ih,
                        size: savedData.size * min
                    };
                } else {
                    // Default: full square centered
                    var s = Math.min(iw, ih);
                    self.crop = { x: (iw - s) / 2, y: (ih - s) / 2, size: s };
                }
                self._clampCrop();
                self._updateBox();
            });
        };
        this.img.src = src;
    };

    ProfileCropper.prototype._render = function () {
        var maxW = Math.min(this.wrap.clientWidth || 500, 500);
        var maxH = 420;
        var iw = this.img.naturalWidth, ih = this.img.naturalHeight;
        var w = iw, h = ih;
        if (w > maxW) { h = Math.round(h * maxW / w); w = maxW; }
        if (h > maxH) { w = Math.round(w * maxH / h); h = maxH; }
        this.canvas.width  = w;
        this.canvas.height = h;
        this.canvas.style.width  = w + 'px';
        this.canvas.style.height = h + 'px';
        this.scale = w / iw;
        var ctx = this.canvas.getContext('2d');
        ctx.fillStyle = getComputedStyle(document.documentElement).getPropertyValue('--bg-subtle').trim() || '#f3f4f6';
        ctx.fillRect(0, 0, w, h);
        ctx.drawImage(this.img, 0, 0, w, h);
    };

    ProfileCropper.prototype._clampCrop = function () {
        var iw = this.img.naturalWidth, ih = this.img.naturalHeight;
        var min = 20 / this.scale;
        this.crop.size = Math.max(min, Math.min(this.crop.size, iw, ih));
        this.crop.x = Math.max(0, Math.min(iw - this.crop.size, this.crop.x));
        this.crop.y = Math.max(0, Math.min(ih - this.crop.size, this.crop.y));
    };

    ProfileCropper.prototype._updateBox = function () {
        var s = this.scale;
        this.box.style.left   = (this.crop.x * s) + 'px';
        this.box.style.top    = (this.crop.y * s) + 'px';
        this.box.style.width  = (this.crop.size * s) + 'px';
        this.box.style.height = (this.crop.size * s) + 'px';
    };

    ProfileCropper.prototype._startPointer = function (el, onStart) {
        el.addEventListener('pointerdown', function (e) {
            if (e.button !== undefined && e.button !== 0) return;
            e.preventDefault();
            e.stopPropagation();
            el.setPointerCapture(e.pointerId);
            var state = onStart(e.clientX, e.clientY);
            function onMove(e) { e.preventDefault(); state.move(e.clientX, e.clientY); }
            function onUp()   { el.removeEventListener('pointermove', onMove); el.removeEventListener('pointerup', onUp); }
            el.addEventListener('pointermove', onMove);
            el.addEventListener('pointerup', onUp);
        });
    };

    ProfileCropper.prototype._bindDrag = function () {
        var self = this;
        this._startPointer(this.box, function (sx, sy) {
            var start = { x: self.crop.x, y: self.crop.y };
            var iw = self.img.naturalWidth, ih = self.img.naturalHeight;
            return {
                move: function (mx, my) {
                    var dx = (mx - sx) / self.scale;
                    var dy = (my - sy) / self.scale;
                    self.crop.x = Math.max(0, Math.min(iw - self.crop.size, start.x + dx));
                    self.crop.y = Math.max(0, Math.min(ih - self.crop.size, start.y + dy));
                    self._updateBox();
                }
            };
        });
    };

    ProfileCropper.prototype._bindHandles = function () {
        var self = this;
        this.box.querySelectorAll('.pcrop-handle').forEach(function (h) {
            var pos = h.dataset.corner;
            self._startPointer(h, function (sx, sy) {
                var start = { x: self.crop.x, y: self.crop.y, size: self.crop.size };
                var iw = self.img.naturalWidth, ih = self.img.naturalHeight;
                var minPx = 30;
                return {
                    move: function (mx, my) {
                        var dx = (mx - sx) / self.scale;
                        var dy = (my - sy) / self.scale;
                        var cx = start.x, cy = start.y, size = start.size;
                        var min = minPx / self.scale;
                        // Anchor corners and compute new size
                        if (pos === 'se') {
                            size = Math.max(min, Math.min(
                                start.x + start.size + dx - cx,
                                start.y + start.size + dy - cy
                            ));
                        } else if (pos === 'sw') {
                            var ax = start.x + start.size;
                            size = Math.max(min, Math.min(ax - (start.x + dx), start.y + start.size + dy - cy));
                            cx = ax - size;
                        } else if (pos === 'ne') {
                            var ay = start.y + start.size;
                            size = Math.max(min, Math.min(start.x + start.size + dx - cx, ay - (start.y + dy)));
                            cy = ay - size;
                        } else { // nw
                            var axnw = start.x + start.size, aynw = start.y + start.size;
                            size = Math.max(min, Math.min(axnw - (start.x + dx), aynw - (start.y + dy)));
                            cx = axnw - size; cy = aynw - size;
                        }
                        cx = Math.max(0, cx); cy = Math.max(0, cy);
                        if (cx + size > iw) size = iw - cx;
                        if (cy + size > ih) size = ih - cy;
                        size = Math.max(min, size);
                        self.crop = { x: cx, y: cy, size: size };
                        self._updateBox();
                    }
                };
            });
        });
    };

    ProfileCropper.prototype.getCroppedCanvas = function (size) {
        var out = document.createElement('canvas');
        out.width = out.height = size;
        var ctx = out.getContext('2d');
        ctx.fillStyle = '#fff';
        ctx.fillRect(0, 0, size, size);
        ctx.drawImage(this.img, this.crop.x, this.crop.y, this.crop.size, this.crop.size, 0, 0, size, size);
        return out;
    };

    ProfileCropper.prototype.getSaveData = function () {
        var min = Math.min(this.img.naturalWidth, this.img.naturalHeight);
        return {
            x:    this.crop.x    / this.img.naturalWidth,
            y:    this.crop.y    / this.img.naturalHeight,
            size: this.crop.size / min
        };
    };

    // ── Crop init ───────────────────────────────────────────────
    var hasPhoto    = <?= json_encode((bool) $user['has_photo']) ?>;
    var cropper     = null;
    var newSrcFile  = null;
    var cropKey     = 'profile_crop_v2';

    function showCropSection() {
        document.getElementById('upload-prompt').style.display = 'none';
        document.getElementById('crop-section').style.display = 'block';
    }

    function initCropper(src, restore) {
        showCropSection();
        if (!cropper) {
            cropper = new ProfileCropper(document.getElementById('cropper-wrap'));
        }
        var saved = null;
        if (restore) {
            try { saved = JSON.parse(localStorage.getItem(cropKey) || 'null'); } catch (e) {}
        }
        cropper.load(src, saved);
    }

    if (hasPhoto) {
        initCropper('/profile/photo/source', true);
    }

    document.getElementById('photo-file-input').addEventListener('change', function (e) {
        var file = e.target.files[0];
        if (!file) return;
        newSrcFile = file;
        localStorage.removeItem(cropKey);
        initCropper(URL.createObjectURL(file), false);
        document.getElementById('photo-error').style.display = 'none';
    });

    document.getElementById('btn-save-photo').addEventListener('click', function () {
        if (!cropper) return;
        var btn = this;
        localStorage.setItem(cropKey, JSON.stringify(cropper.getSaveData()));
        var canvas = cropper.getCroppedCanvas(256);
        btn.textContent = LANG.saving;
        btn.disabled = true;
        canvas.toBlob(function (blob) {
            var fd = new FormData();
            fd.append('photo', blob, 'photo.jpg');
            if (newSrcFile) fd.append('source', newSrcFile);
            fetch('/profile/photo', { method: 'POST', body: fd })
                .then(function (r) { return r.json(); })
                .then(function (data) {
                    if (data.ok) {
                        location.reload();
                    } else {
                        document.getElementById('photo-error').textContent = data.error || LANG.error;
                        document.getElementById('photo-error').style.display = 'block';
                        btn.textContent = LANG.savePhoto;
                        btn.disabled = false;
                    }
                });
        }, 'image/jpeg', 0.92);
    });

    // ── Email popup ─────────────────────────────────────────────
    document.getElementById('btn-open-email').addEventListener('click', function () {
        ['email-current','email-new','email-code-old','email-code-new'].forEach(function (id) {
            var el = document.getElementById(id); if (el) el.value = '';
        });
        ['err-email-current','err-email-new','err-code-old','err-code-new'].forEach(function (id) { setErr(id, ''); });
        document.getElementById('email-step-1').classList.add('active');
        document.getElementById('email-step-2').classList.remove('active');
        document.getElementById('popup-email').classList.add('open');
    });

    document.getElementById('btn-email-send').addEventListener('click', function () {
        var btn = this;
        setErr('err-email-current', ''); setErr('err-email-new', '');
        var cur = document.getElementById('email-current').value.trim();
        var nw  = document.getElementById('email-new').value.trim();
        if (!cur) { setErr('err-email-current', LANG.required); return; }
        if (!nw)  { setErr('err-email-new', LANG.required); return; }
        btn.textContent = LANG.sending; btn.disabled = true;
        var fd = new FormData(); fd.append('current_email', cur); fd.append('new_email', nw);
        fetch('/profile/email/request', { method: 'POST', body: fd })
            .then(function (r) { return r.json(); })
            .then(function (data) {
                btn.textContent = LANG.sendCodes; btn.disabled = false;
                if (data.ok) {
                    document.getElementById('email-step-1').classList.remove('active');
                    document.getElementById('email-step-2').classList.add('active');
                } else {
                    var isCurrentErr = data.error && data.error.toLowerCase().indexOf('current') !== -1;
                    setErr(isCurrentErr ? 'err-email-current' : 'err-email-new', data.error || LANG.error);
                }
            });
    });

    document.getElementById('btn-email-verify').addEventListener('click', function () {
        var btn = this;
        setErr('err-code-old', ''); setErr('err-code-new', '');
        var co = document.getElementById('email-code-old').value.trim();
        var cn = document.getElementById('email-code-new').value.trim();
        if (!co) { setErr('err-code-old', LANG.required); return; }
        if (!cn) { setErr('err-code-new', LANG.required); return; }
        btn.textContent = LANG.verifying; btn.disabled = true;
        var fd = new FormData(); fd.append('code_old', co); fd.append('code_new', cn);
        fetch('/profile/email/verify', { method: 'POST', body: fd })
            .then(function (r) { return r.json(); })
            .then(function (data) {
                btn.textContent = LANG.confirm; btn.disabled = false;
                if (data.ok) { closePopup('popup-email'); location.reload(); }
                else {
                    var isOldErr = data.error && data.error.toLowerCase().indexOf('current') !== -1;
                    setErr(isOldErr ? 'err-code-old' : 'err-code-new', data.error || LANG.error);
                }
            });
    });

    // ── Password popup ──────────────────────────────────────────
    document.getElementById('btn-open-password').addEventListener('click', function () {
        ['pw-current','pw-new','pw-confirm'].forEach(function (id) { document.getElementById(id).value = ''; });
        ['err-pw-current','err-pw-new','err-pw-confirm'].forEach(function (id) { setErr(id, ''); });
        document.getElementById('popup-password').classList.add('open');
    });

    document.getElementById('btn-pw-save').addEventListener('click', function () {
        var btn = this;
        ['err-pw-current','err-pw-new','err-pw-confirm'].forEach(function (id) { setErr(id, ''); });
        var cur  = document.getElementById('pw-current').value;
        var nw   = document.getElementById('pw-new').value;
        var conf = document.getElementById('pw-confirm').value;
        var ok   = true;
        if (!cur)           { setErr('err-pw-current', LANG.required); ok = false; }
        if (nw.length < 8)  { setErr('err-pw-new', LANG.pwTooShort); ok = false; }
        if (nw !== conf)    { setErr('err-pw-confirm', LANG.pwNoMatch); ok = false; }
        if (!ok) return;
        btn.textContent = LANG.saving; btn.disabled = true;
        var fd = new FormData();
        fd.append('current_password', cur);
        fd.append('new_password', nw);
        fd.append('confirm_password', conf);
        fetch('/profile/password', { method: 'POST', body: fd })
            .then(function (r) { return r.json(); })
            .then(function (data) {
                btn.textContent = LANG.save; btn.disabled = false;
                if (data.ok) {
                    closePopup('popup-password');
                    var wrap = document.querySelector('.wrapper');
                    var flash = document.createElement('div');
                    flash.className = 'flash success';
                    flash.textContent = LANG.passwordUpdated;
                    wrap.insertBefore(flash, wrap.firstChild);
                } else { setErr('err-pw-current', data.error || LANG.error); }
            });
    });
})();
</script>
