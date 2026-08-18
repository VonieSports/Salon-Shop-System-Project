{{-- <div style="min-height: 93vh; background: linear-gradient(to bottom, #f1f5f9, #e2e8f0); display: flex; align-items: center; justify-content: center; padding: 1.5rem; font-family: system-ui, -apple-system, sans-serif;">
    <div style="background: #ffffff; border-radius: 1.25rem; box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08), 0 1px 3px rgba(0, 0, 0, 0.05); max-width: 32rem; width: 100%; overflow: hidden;">
        <div style="background: #0f172a; padding: 1.5rem 2rem; display: flex; justify-content: space-between; align-items: center;">
            <div style="display: flex; align-items: center; gap: 0.75rem;">
                <svg style="width: 1.5rem; height: 1.5rem; color: #ffffff;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                </svg>
                <span style="color: #ffffff; font-weight: 600; font-size: 1rem; letter-spacing: 0.02em;">Via Online Payment</span>
            </div>
        </div>

        <div style="padding: 2rem;">
            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 0.5rem;">
                <div>
                    <p style="font-size: 0.875rem; color: #64748b; font-weight: 500; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.25rem;">Pay to</p>
                    <p style="font-size: 1rem; font-weight: 600; color: #0f172a;">{{ $order->tenant?->name ?? 'Style Station' }}</p>
                </div>
                <div style="text-align: right;">
                    <p style="font-size: 0.75rem; color: #94a3b8;">Order #{{ $order->order_number }}</p>
                </div>
            </div>

            <div style="background: #f8fafc; border-radius: 0.75rem; padding: 1.5rem; text-align: center; border: 1px solid #f1f5f9; margin: 1rem 0;">
                <p style="font-size: 0.875rem; color: #64748b; font-weight: 500; margin-bottom: 0.25rem;">Total Amount Due</p>
                <h1 style="font-size: 3rem; font-weight: 700; color: #0f172a; line-height: 1; margin: 0;">
                    ₱{{ number_format($order->total, 2) }}
                </h1>
            </div>

            <div style="border-top: 1px solid #f1f5f9; border-bottom: 1px solid #f1f5f9; padding: 1rem 0; margin: 1.5rem 0; display: flex; flex-direction: column; gap: 0.75rem;">
                <div style="display: flex; justify-content: space-between; font-size: 0.875rem;">
                    <span style="color: #64748b;">Payment Method</span>
                    <span style="color: #0f172a; font-weight: 500; display: flex; align-items: center; gap: 0.5rem;">
                        <span style="display: flex; gap: 2px;">
                            <svg width="24" height="16" viewBox="0 0 24 16" fill="none"><rect width="24" height="16" rx="2" fill="#1a1f71"/><path d="M9 11H11L13 6H11L9 11Z" fill="#fff"/><path d="M16 11H19L20 6H17L16 11Z" fill="#fff"/></svg>
                            <svg width="24" height="16" viewBox="0 0 24 16" fill="none"><rect width="24" height="16" rx="2" fill="#ff5f00"/><path d="M9 3H15V13H9V3Z" fill="#eb001b"/><path d="M9 3H15V13H9V3Z" fill="#f79e1b"/></svg>
                        </span>
                        <span>Online Payment</span>
                    </span>
                </div>
                <div style="display: flex; justify-content: space-between; font-size: 0.875rem;">
                    <span style="color: #64748b;">Transaction Status</span>
                    <span style="font-weight: 500; color: #f59e0b; display: flex; align-items: center; gap: 0.5rem;">
                        <span style="display: inline-block; width: 0.5rem; height: 0.5rem; border-radius: 9999px; background: #f59e0b;"></span>
                        Awaiting Payment
                    </span>
                </div>
            </div>

            <div style="display: flex; justify-content: center; gap: 1.5rem; font-size: 0.75rem; color: #94a3b8; margin-bottom: 1.5rem;">
                <span style="display: flex; align-items: center; gap: 0.375rem;">
                    <svg style="width: 1rem; height: 1rem;" fill="none" stroke="#64748b" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    Secured
                </span>
                <span style="display: flex; align-items: center; gap: 0.375rem;">
                    <svg style="width: 1rem; height: 1rem;" fill="none" stroke="#64748b" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                    Encrypted
                </span>
                <span style="display: flex; align-items: center; gap: 0.375rem;">
                    <svg style="width: 1rem; height: 1rem;" fill="none" stroke="#64748b" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                    Protected
                </span>
            </div>

            <form method="POST" action="{{ route('customer.payment.demo.confirm', $pending->paymongo_link_id) }}" style="margin-top: 0.5rem;">
                @csrf
                <button type="submit" 
                        style="width: 100%; background: #0e774b; color: #ffffff; font-weight: 600; padding: 0.75rem 1rem; border: none; border-radius: 0.75rem; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 0.5rem; transition: all 0.2s ease; font-size: 0.875rem;"
                        onmouseenter="this.style.background='#007849'; this.style.transform='translateY(-1px)'; this.style.boxShadow='0 8px 25px rgba(0, 155, 90, 0.3)';"
                        onmouseleave="this.style.background='#009b5a'; this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                    
                    <span style="font-size: 1rem;"> Pay Now</span>
                </button>
            </form>
        </div>
    </div>
</div> --}}