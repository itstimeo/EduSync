<?php
// Required vars: $colorPickerName (string), $colorPickerValue (string)
$palette_vivid = [
    '#ef4444','#f97316','#f59e0b','#eab308','#22c55e',
    '#10b981','#06b6d4','#3b82f6','#6366f1','#ec4899',
];
$palette_pastel = [
    '#fca5a5','#fdba74','#fde68a','#bbf7d0','#6ee7b7',
    '#a5f3fc','#bfdbfe','#a5b4fc','#f9a8d4','#e5e7eb',
];
$pid = 'cp_' . preg_replace('/\W/', '_', $colorPickerName);
$cv  = $colorPickerValue ?: '#6366f1';
static $cpLoaded = false;
?>
<?php if (!$cpLoaded): $cpLoaded = true; ?>
<style>
.cp-wrap{position:relative;display:inline-block}
.cp-trigger{display:inline-flex;align-items:center;gap:.5rem;padding:.4rem .75rem;border:1px solid var(--border-soft);border-radius:6px;cursor:pointer;background:var(--surface);font-size:.875rem}
.cp-trigger:hover{border-color:#6366f1}
.cp-swatch-preview{width:20px;height:20px;border-radius:4px;border:1px solid rgba(0,0,0,.1);flex-shrink:0}
.cp-hex-label{font-family:monospace;color:var(--text);font-size:.8rem}
.cp-caret{color:var(--text-subtle);font-size:.65rem}
.cp-popover{display:none;position:absolute;top:calc(100% + 6px);left:0;z-index:200;background:var(--surface);border:1px solid var(--border);border-radius:10px;padding:.85rem;box-shadow:0 6px 24px rgba(0,0,0,.13);min-width:210px}
.cp-section-label{font-size:.7rem;font-weight:600;color:var(--text-subtle);text-transform:uppercase;letter-spacing:.05em;margin-bottom:.35rem}
.cp-grid{display:grid;grid-template-columns:repeat(5,1fr);gap:5px;margin-bottom:.5rem}
.cp-dot{width:30px;height:30px;border-radius:6px;cursor:pointer;border:2px solid rgba(0,0,0,.1);transition:transform .1s}
.cp-dot:hover{transform:scale(1.15)}
.cp-dot.sel{box-shadow:0 0 0 2px var(--surface),0 0 0 4px rgba(99,102,241,.7)}
.cp-hex-row{display:flex;align-items:center;gap:.4rem;border-top:1px solid var(--bg-subtle);padding-top:.6rem;margin-bottom:.5rem}
.cp-hex-row label{font-size:.75rem;color:var(--text-subtle);flex-shrink:0}
.cp-hex-input{flex:1;padding:.3rem .45rem;border:1px solid var(--border-soft);border-radius:4px;font-size:.8rem;font-family:monospace;background:var(--input-bg);color:var(--text)}
.cp-custom-btn{display:block;width:100%;padding:.4rem;border:1px dashed var(--border-soft);border-radius:6px;background:none;cursor:pointer;font-size:.8rem;color:var(--text-muted);text-align:center}
.cp-custom-btn:hover{background:var(--bg-hover);border-color:#6366f1;color:#6366f1}
/* Advanced picker */
#adv-picker{display:none;position:fixed;inset:0;background:rgba(0,0,0,.45);z-index:1000;align-items:center;justify-content:center}
#adv-box{background:var(--surface);border-radius:12px;padding:1.1rem;box-shadow:0 8px 32px rgba(0,0,0,.18);width:282px}
#adv-canvas{border-radius:6px;cursor:crosshair;display:block;margin-bottom:.4rem}
#adv-hue{border-radius:4px;cursor:ew-resize;display:block;margin-bottom:.75rem}
.adv-hex-row{display:flex;align-items:center;gap:.5rem;margin-bottom:.75rem}
.adv-hex-field{flex:1;display:flex;align-items:center;border:1px solid var(--border-soft);border-radius:5px;overflow:hidden}
.adv-hex-field span{padding:.35rem .3rem .35rem .5rem;font-family:monospace;font-size:.85rem;color:var(--text-subtle);flex-shrink:0;background:var(--bg-hover);border-right:1px solid var(--border)}
.adv-hex-field:focus-within{border-color:#6366f1;box-shadow:0 0 0 3px rgba(99,102,241,.12)}
#adv-hex{flex:1;padding:.35rem .5rem;border:none;font-family:monospace;font-size:.85rem;background:var(--surface);color:var(--text)}
#adv-hex:focus{outline:none}
#adv-preview{width:34px;height:34px;border-radius:6px;border:1px solid var(--border);flex-shrink:0}
.adv-btns{display:flex;gap:.5rem}
.adv-btns button{flex:1;padding:.45rem;border-radius:6px;font-size:.85rem;cursor:pointer;font-weight:500}
#adv-cancel-btn{border:1px solid var(--border-soft);background:var(--bg-subtle);color:var(--text)}
#adv-apply-btn{border:none;background:#6366f1;color:#fff}
#adv-apply-btn:hover{background:#4f46e5}
@media (max-width: 640px) {
    .cp-popover { position: fixed !important; left: 50% !important; top: 50% !important; transform: translate(-50%, -50%) !important; max-height: 80vh; overflow-y: auto; }
}
</style>

<div id="adv-picker">
    <div id="adv-box">
        <canvas id="adv-canvas" width="246" height="160"></canvas>
        <canvas id="adv-hue" width="246" height="16"></canvas>
        <div class="adv-hex-row">
            <div class="adv-hex-field">
                <span>#</span>
                <input type="text" id="adv-hex" maxlength="6" placeholder="6366f1">
            </div>
            <div id="adv-preview"></div>
        </div>
        <div class="adv-btns">
            <button type="button" id="adv-cancel-btn">Cancel</button>
            <button type="button" id="adv-apply-btn">Apply</button>
        </div>
    </div>
</div>

<script>
(function () {
    // ── Helpers ──────────────────────────────────────────────────────
    function hsvToHex(h, s, v) {
        s /= 100; v /= 100;
        var c = v * s, x = c * (1 - Math.abs((h / 60) % 2 - 1)), m = v - c, r, g, b;
        if (h < 60)  { r=c; g=x; b=0; } else if (h < 120) { r=x; g=c; b=0; }
        else if (h < 180) { r=0; g=c; b=x; } else if (h < 240) { r=0; g=x; b=c; }
        else if (h < 300) { r=x; g=0; b=c; } else { r=c; g=0; b=x; }
        return '#' + [r+m, g+m, b+m].map(function (n) {
            return Math.round(n * 255).toString(16).padStart(2, '0');
        }).join('');
    }
    function hexToHsv(hex) {
        hex = hex.replace('#', '');
        if (!/^[0-9a-fA-F]{6}$/.test(hex)) return { h: 210, s: 80, v: 80 };
        var r = parseInt(hex.substr(0,2),16)/255, g = parseInt(hex.substr(2,2),16)/255, b = parseInt(hex.substr(4,2),16)/255;
        var max = Math.max(r,g,b), min = Math.min(r,g,b), d = max - min, h = 0, s = max === 0 ? 0 : d / max, v = max;
        if (max !== min) {
            if (max === r) h = ((g-b)/d + (g < b ? 6 : 0)) / 6;
            else if (max === g) h = ((b-r)/d + 2) / 6;
            else h = ((r-g)/d + 4) / 6;
        }
        return { h: Math.round(h*360), s: Math.round(s*100), v: Math.round(v*100) };
    }

    // ── Simple picker ─────────────────────────────────────────────────
    window.cpToggle = function (id) {
        var p = document.getElementById(id + '_pop');
        p.style.display = p.style.display === 'none' ? 'block' : 'none';
    };
    window.cpPick = function (id, hex) {
        document.getElementById(id + '_in').value   = hex;
        document.getElementById(id + '_hex').value  = hex;
        document.getElementById(id + '_prev').style.background = hex;
        document.getElementById(id + '_lbl').textContent = hex;
        document.querySelectorAll('#' + id + '_pop .cp-dot').forEach(function (d) {
            d.classList.toggle('sel', d.dataset.c === hex);
        });
        document.getElementById(id + '_pop').style.display = 'none';
    };
    window.cpHex = function (id, val) {
        if (/^#[0-9a-fA-F]{6}$/.test(val)) {
            document.getElementById(id + '_in').value = val;
            document.getElementById(id + '_prev').style.background = val;
            document.getElementById(id + '_lbl').textContent = val;
            document.querySelectorAll('#' + id + '_pop .cp-dot').forEach(function (d) {
                d.classList.toggle('sel', d.dataset.c === val);
            });
        }
    };
    document.addEventListener('click', function (e) {
        document.querySelectorAll('.cp-wrap').forEach(function (w) {
            if (!w.contains(e.target)) w.querySelector('.cp-popover').style.display = 'none';
        });
    });

    // ── Advanced picker ───────────────────────────────────────────────
    var adv = {
        id: null, hue: 210, sat: 80, val: 80,
        dragging: false, hueDragging: false,
        cv: function () { return document.getElementById('adv-canvas'); },
        ch: function () { return document.getElementById('adv-hue'); },

        open: function (id, hex) {
            this.id = id;
            var hsv = hexToHsv(hex);
            this.hue = hsv.h; this.sat = hsv.s; this.val = hsv.v;
            document.getElementById('adv-hex').value = hex.replace('#', '');
            document.getElementById('adv-preview').style.background = hex;
            document.getElementById('adv-picker').style.display = 'flex';
            this.drawAll();
        },

        drawCanvas: function () {
            var c = this.cv(), ctx = c.getContext('2d'), w = c.width, h = c.height;
            var hc = hsvToHex(this.hue, 100, 100);
            var gh = ctx.createLinearGradient(0, 0, w, 0);
            gh.addColorStop(0, '#fff'); gh.addColorStop(1, hc);
            ctx.fillStyle = gh; ctx.fillRect(0, 0, w, h);
            var gv = ctx.createLinearGradient(0, 0, 0, h);
            gv.addColorStop(0, 'rgba(0,0,0,0)'); gv.addColorStop(1, '#000');
            ctx.fillStyle = gv; ctx.fillRect(0, 0, w, h);
            // Indicator
            var x = this.sat / 100 * w, y = (1 - this.val / 100) * h;
            ctx.beginPath(); ctx.arc(x, y, 7, 0, 2 * Math.PI);
            ctx.strokeStyle = '#fff'; ctx.lineWidth = 2; ctx.stroke();
            ctx.beginPath(); ctx.arc(x, y, 7, 0, 2 * Math.PI);
            ctx.strokeStyle = 'rgba(0,0,0,.3)'; ctx.lineWidth = 1; ctx.stroke();
        },

        drawHue: function () {
            var c = this.ch(), ctx = c.getContext('2d'), w = c.width;
            var g = ctx.createLinearGradient(0, 0, w, 0);
            for (var i = 0; i <= 6; i++) g.addColorStop(i / 6, 'hsl(' + (i * 60) + ',100%,50%)');
            ctx.fillStyle = g; ctx.fillRect(0, 0, w, c.height);
            var x = this.hue / 360 * w;
            ctx.strokeStyle = '#fff'; ctx.lineWidth = 2;
            ctx.beginPath(); ctx.moveTo(x, 0); ctx.lineTo(x, c.height); ctx.stroke();
        },

        drawAll: function () { this.drawCanvas(); this.drawHue(); },

        syncHex: function () {
            var hex = hsvToHex(this.hue, this.sat, this.val);
            document.getElementById('adv-hex').value = hex.replace('#', '');
            document.getElementById('adv-preview').style.background = hex;
        },

        pos: function (e, el) {
            var r = el.getBoundingClientRect();
            return {
                x: Math.max(0, Math.min((e.clientX - r.left) * el.width / r.width, el.width)),
                y: Math.max(0, Math.min((e.clientY - r.top) * el.height / r.height, el.height))
            };
        }
    };

    window.advPickerOpen = function (id) {
        var hex = document.getElementById(id + '_in').value || '#6366f1';
        adv.open(id, hex);
        document.getElementById(id + '_pop').style.display = 'none';
    };

    // Canvas events
    document.getElementById('adv-canvas').addEventListener('mousedown', function (e) {
        adv.dragging = true;
        var p = adv.pos(e, this);
        adv.sat = Math.round(p.x / this.width * 100);
        adv.val = Math.round((1 - p.y / this.height) * 100);
        adv.syncHex(); adv.drawCanvas();
    });
    document.getElementById('adv-hue').addEventListener('mousedown', function (e) {
        adv.hueDragging = true;
        var p = adv.pos(e, this);
        adv.hue = Math.round(p.x / this.width * 360);
        adv.syncHex(); adv.drawAll();
    });
    document.addEventListener('mousemove', function (e) {
        if (adv.dragging) {
            var c = document.getElementById('adv-canvas'), p = adv.pos(e, c);
            adv.sat = Math.round(p.x / c.width * 100);
            adv.val = Math.round((1 - p.y / c.height) * 100);
            adv.syncHex(); adv.drawCanvas();
        }
        if (adv.hueDragging) {
            var hc = document.getElementById('adv-hue'), p = adv.pos(e, hc);
            adv.hue = Math.round(p.x / hc.width * 360);
            adv.syncHex(); adv.drawAll();
        }
    });
    document.addEventListener('mouseup', function () { adv.dragging = false; adv.hueDragging = false; });

    document.getElementById('adv-hex').addEventListener('input', function () {
        var val = this.value.replace(/[^0-9a-fA-F]/g, '').slice(0, 6);
        this.value = val;
        if (val.length === 6) {
            var hsv = hexToHsv('#' + val);
            adv.hue = hsv.h; adv.sat = hsv.s; adv.val = hsv.v;
            document.getElementById('adv-preview').style.background = '#' + val;
            adv.drawAll();
        }
    });

    document.getElementById('adv-apply-btn').addEventListener('click', function () {
        var hex = '#' + document.getElementById('adv-hex').value;
        if (/^#[0-9a-fA-F]{6}$/.test(hex) && adv.id) {
            cpPick(adv.id, hex);
            document.getElementById(adv.id + '_hex').value = hex;
        }
        document.getElementById('adv-picker').style.display = 'none';
    });
    document.getElementById('adv-cancel-btn').addEventListener('click', function () {
        document.getElementById('adv-picker').style.display = 'none';
    });
    document.getElementById('adv-picker').addEventListener('click', function (e) {
        if (e.target === this) this.style.display = 'none';
    });
})();
</script>
<?php endif; ?>

<div class="cp-wrap" id="<?= $pid ?>_wrap">
    <input type="hidden" name="<?= htmlspecialchars($colorPickerName, ENT_QUOTES) ?>"
           id="<?= $pid ?>_in" value="<?= htmlspecialchars($cv, ENT_QUOTES) ?>">
    <button type="button" class="cp-trigger" onclick="cpToggle('<?= $pid ?>')">
        <span class="cp-swatch-preview" id="<?= $pid ?>_prev"
              style="background:<?= htmlspecialchars($cv, ENT_QUOTES) ?>"></span>
        <span class="cp-hex-label" id="<?= $pid ?>_lbl"><?= htmlspecialchars($cv, ENT_QUOTES) ?></span>
        <span class="cp-caret">▼</span>
    </button>
    <div class="cp-popover" id="<?= $pid ?>_pop">
        <div class="cp-section-label">Vivid</div>
        <div class="cp-grid">
            <?php foreach ($palette_vivid as $hex): ?>
                <button type="button" class="cp-dot <?= $hex === $cv ? 'sel' : '' ?>"
                        style="background:<?= $hex ?>" data-c="<?= $hex ?>"
                        onclick="cpPick('<?= $pid ?>','<?= $hex ?>')" title="<?= $hex ?>"></button>
            <?php endforeach; ?>
        </div>
        <div class="cp-section-label">Pastel</div>
        <div class="cp-grid" style="margin-bottom:.65rem">
            <?php foreach ($palette_pastel as $hex): ?>
                <button type="button" class="cp-dot <?= $hex === $cv ? 'sel' : '' ?>"
                        style="background:<?= $hex ?>;<?= $hex === '#e5e7eb' ? 'border-color:#d1d5db' : '' ?>"
                        data-c="<?= $hex ?>"
                        onclick="cpPick('<?= $pid ?>','<?= $hex ?>')" title="<?= $hex ?>"></button>
            <?php endforeach; ?>
        </div>
        <div class="cp-hex-row">
            <label>Hex</label>
            <input type="text" class="cp-hex-input" id="<?= $pid ?>_hex"
                   value="<?= htmlspecialchars($cv, ENT_QUOTES) ?>"
                   placeholder="#000000" maxlength="7"
                   oninput="cpHex('<?= $pid ?>',this.value)">
        </div>
        <button type="button" class="cp-custom-btn" onclick="advPickerOpen('<?= $pid ?>')">
            + Custom color
        </button>
    </div>
</div>
