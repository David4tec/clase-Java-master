@extends('layouts.storefront')
@section('title', 'Contact Us')

@section('content')
<script>
    const _contactUrl  = @json(route('contact.message'));
    const _contactCsrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ?? '';

    function contactFormData() {
        return {
            sent: false, sending: false,
            email: '', subject: '', message: '',
            async sendMessage() {
                if (!this.email || !this.subject || !this.message) return;
                this.sending = true;
                try {
                    const res = await fetch(_contactUrl, {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json', 'X-CSRF-Token': _contactCsrf },
                        body: JSON.stringify({ email: this.email, subject: this.subject, message: this.message })
                    });
                    const data = await res.json();
                    if (data.success) { this.sent = true; }
                    else { alert('Error: ' + (data.message || 'Unknown error')); }
                } catch(e) {
                    alert('Error sending message. Please try again.');
                } finally {
                    this.sending = false;
                }
            }
        };
    }
</script>

<div class="max-w-3xl mx-auto px-6 py-14" x-data="contactFormData()">

    <h1 class="text-2xl font-black tracking-[0.2em] uppercase text-center mb-3" style="color: #1e3a8a;">Contact Us</h1>
    <p class="text-sm text-center text-gray-600 mb-10 max-w-lg mx-auto leading-relaxed">
        Feel free to contact us with any doubts, questions, or suggestions you may have using the form below.
    </p>

    {{-- Success state --}}
    <template x-if="sent">
        <div class="kf-card text-center py-12">
            <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            <p class="font-bold text-gray-800 text-lg mb-2">Message sent! We'll get back to you soon.</p>
            <button @click="sent = false" class="kf-btn-outline mt-4 text-sm kf-btn-sm">
                Send another message
            </button>
        </div>
    </template>

    {{-- Contact Form --}}
    <template x-if="!sent">
        <div class="rounded-2xl p-8 shadow-sm" style="background-color: #b8c2dc;">
            <form @submit.prevent="sendMessage()" class="space-y-5">

                <div class="flex flex-col sm:flex-row sm:items-center gap-2">
                    <label class="text-sm font-semibold text-gray-700 sm:w-36 flex-shrink-0">E-mail address:</label>
                    <input type="email" x-model="email" required placeholder="your@email.com" class="kf-input flex-1" style="background: white;" />
                </div>

                <div class="flex flex-col sm:flex-row sm:items-center gap-2">
                    <label class="text-sm font-semibold text-gray-700 sm:w-36 flex-shrink-0">Subject:</label>
                    <input type="text" x-model="subject" required placeholder="How can we help?" class="kf-input flex-1" style="background: white;" />
                </div>

                <div class="flex flex-col gap-2">
                    <label class="text-sm font-semibold text-gray-700">Message:</label>
                    <textarea x-model="message" required rows="7" placeholder="Write your message here..." class="kf-input resize-none" style="background: white;"></textarea>
                </div>

                <div class="pt-2">
                    <button type="submit" :disabled="sending" class="kf-btn w-full"
                            x-text="sending ? 'Sending...' : 'Send Message'">
                    </button>
                </div>
            </form>
        </div>
    </template>

</div>
@endsection
