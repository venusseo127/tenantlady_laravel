<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\Payment;
use App\Services\FirebaseNotificationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class PaymentController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();

        if ($user->isLandlord()) {
            $payments = Payment::whereIn('bill_id', Bill::whereIn('listing_id', $user->listings()->pluck('id'))->pluck('id'))
                ->with(['bill.tenant', 'tenant'])
                ->latest()
                ->paginate(20);
            return view('payments.index', compact('payments'));
        }

        $tenantIds = $user->tenantRecords->pluck('id');
        $payments = Payment::whereIn('tenant_id', $tenantIds)->with(['bill', 'tenant'])->latest()->paginate(20);
        return view('payments.index', compact('payments'));
    }

    public function create(Bill $bill): View|RedirectResponse
    {
        $user = request()->user();
        $tenant = $bill->tenant;
        if ($tenant->account_id !== $user->id && !$user->isLandlord()) {
            abort(403);
        }
        if ($user->isLandlord()) {
            return redirect()->route('bills.show', $bill)->with('error', 'Landlords cannot upload payment proof.');
        }
        return view('payments.create', compact('bill'));
    }

    public function store(Request $request, Bill $bill): RedirectResponse
    {
        $user = $request->user();
        $tenant = $bill->tenant;
        if ($tenant->account_id !== $user->id) {
            abort(403);
        }

        $request->validate([
            'proof_image' => ['required', 'image', 'max:5120'],
        ]);

        $path = $request->file('proof_image')->store('payment_proofs', 'public');

        $payment = Payment::create([
            'bill_id' => $bill->id,
            'tenant_id' => $tenant->id,
            'proof_image' => $path,
            'status' => 'pending',
            'uploaded_at' => now(),
        ]);

        $landlord = $bill->listing->user;
        if ($landlord?->fcm_token) {
            app(FirebaseNotificationService::class)->sendToUser(
                $landlord,
                'Payment proof uploaded',
                "{$tenant->name} uploaded payment proof for {$bill->type} bill (₱" . number_format($bill->amount, 0) . ')',
                ['bill_id' => (string) $bill->id, 'payment_id' => (string) $payment->id, 'type' => 'payment_proof_uploaded']
            );
        }

        return redirect()->route('dashboard')->with('success', 'Payment proof uploaded. Waiting for landlord approval.');
    }

    public function approve(Payment $payment): RedirectResponse
    {
        $user = request()->user();
        if (!$user->isLandlord() || !$user->listings()->where('id', $payment->bill->listing_id)->exists()) {
            abort(403);
        }

        $payment->update(['status' => 'approved']);
        $payment->bill->update(['status' => 'paid']);

        $tenantUser = $payment->tenant->account;
        if ($tenantUser?->fcm_token) {
            app(FirebaseNotificationService::class)->sendToUser(
                $tenantUser,
                'Payment approved',
                "Your payment of ₱" . number_format($payment->bill->amount, 0) . ' has been approved.',
                ['bill_id' => (string) $payment->bill_id, 'type' => 'payment_approved']
            );
        }

        return back()->with('success', 'Payment approved.');
    }

    public function reject(Payment $payment): RedirectResponse
    {
        $user = request()->user();
        if (!$user->isLandlord() || !$user->listings()->where('id', $payment->bill->listing_id)->exists()) {
            abort(403);
        }

        $payment->update(['status' => 'rejected']);
        return back()->with('success', 'Payment rejected.');
    }
}
