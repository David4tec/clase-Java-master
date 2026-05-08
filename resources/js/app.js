import './bootstrap';
import Alpine from 'alpinejs';

window.Alpine = Alpine;

// ── Cart Store (localStorage persistence) ──────────────────────
Alpine.store('cart', {
    items: [],

    init() {
        try {
            const saved = localStorage.getItem('kf_cart');
            if (saved) this.items = JSON.parse(saved);
        } catch (e) {
            this.items = [];
        }
    },

    _save() {
        localStorage.setItem('kf_cart', JSON.stringify(this.items));
    },

    add(product) {
        const existing = this.items.find(
            i => i.id === product.id && i.model === product.model
        );
        if (existing) {
            existing.qty++;
        } else {
            this.items.push({ ...product, qty: 1 });
        }
        this._save();
        window.dispatchEvent(new CustomEvent('cart:updated', { detail: { count: this.count } }));
    },

    remove(id, model) {
        this.items = this.items.filter(
            i => !(i.id === id && i.model === model)
        );
        this._save();
        window.dispatchEvent(new CustomEvent('cart:updated', { detail: { count: this.count } }));
    },

    setQty(id, model, qty) {
        const item = this.items.find(i => i.id === id && i.model === model);
        if (item) {
            item.qty = Math.max(1, parseInt(qty) || 1);
            this._save();
        }
    },

    clear() {
        this.items = [];
        this._save();
    },

    get count() {
        return this.items.reduce((s, i) => s + i.qty, 0);
    },

    get subtotal() {
        return this.items.reduce((s, i) => s + (parseFloat(i.price) * i.qty), 0);
    },

    get total() {
        return this.subtotal;
    }
});

Alpine.start();
