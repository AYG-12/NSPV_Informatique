<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Commande reçue</title>
</head>
<body style="margin:0;padding:0;background:#f4f4f4;font-family:Arial,Helvetica,sans-serif;">

<table width="100%" cellpadding="0" cellspacing="0" style="background:#f4f4f4;padding:40px 0;">
    <tr>
        <td align="center">
            <table width="600" cellpadding="0" cellspacing="0" style="max-width:600px;width:100%;">

                {{-- Header --}}
                <tr>
                    <td style="background:#111111;border-radius:12px 12px 0 0;padding:32px 40px;text-align:center;">
                        <div style="font-size:22px;font-weight:800;color:#ffffff;letter-spacing:-0.5px;">
                            NSPV <span style="color:#e8ff47;">Informatique</span>
                        </div>
                    </td>
                </tr>

                {{-- Body --}}
                <tr>
                    <td style="background:#ffffff;padding:40px;">

                        <h1 style="margin:0 0 8px;font-size:24px;font-weight:800;color:#111111;">
                            Commande reçue ! ✅
                        </h1>
                        <p style="margin:0 0 28px;font-size:15px;color:#555555;line-height:1.6;">
                            Bonjour <strong>{{ $order->user->name }}</strong>,<br>
                            Merci pour votre commande. Nous l'avons bien reçue et elle est en cours de traitement par notre équipe.
                        </p>

                        {{-- Numéro de commande --}}
                        <table width="100%" cellpadding="0" cellspacing="0" style="background:#f9f9f9;border:1px solid #e5e5e5;border-radius:10px;margin-bottom:28px;">
                            <tr>
                                <td style="padding:20px 24px;">
                                    <div style="font-size:12px;color:#888888;text-transform:uppercase;letter-spacing:1px;margin-bottom:4px;">Numéro de commande</div>
                                    <div style="font-size:20px;font-weight:800;color:#111111;letter-spacing:1px;">{{ $order->order_number }}</div>
                                    <div style="font-size:13px;color:#888888;margin-top:6px;">{{ $order->created_at->format('d/m/Y à H\hi') }}</div>
                                </td>
                                <td style="padding:20px 24px;text-align:right;vertical-align:middle;">
                                    @php
                                        $typeLabel = $order->delivery_type === 'pickup' ? 'Retrait boutique' : 'Livraison domicile';
                                    @endphp
                                    <div style="font-size:12px;color:#888888;margin-bottom:4px;">Mode de livraison</div>
                                    <div style="font-size:14px;font-weight:600;color:#111111;">{{ $typeLabel }}</div>
                                </td>
                            </tr>
                        </table>

                        {{-- Articles --}}
                        <div style="font-size:14px;font-weight:700;color:#111111;margin-bottom:12px;text-transform:uppercase;letter-spacing:0.5px;">Articles commandés</div>
                        <table width="100%" cellpadding="0" cellspacing="0" style="border:1px solid #e5e5e5;border-radius:10px;overflow:hidden;margin-bottom:24px;">
                            @foreach($order->items as $item)
                            <tr style="border-bottom:1px solid #f0f0f0;">
                                <td style="padding:14px 20px;font-size:14px;color:#333333;">
                                    <div style="font-weight:600;">{{ $item->product_name }}</div>
                                    <div style="color:#888888;font-size:12px;margin-top:3px;">{{ $item->quantity }} × {{ number_format($item->unit_price, 0, ',', ' ') }} F CFA</div>
                                </td>
                                <td style="padding:14px 20px;text-align:right;font-size:14px;font-weight:700;color:#111111;white-space:nowrap;">
                                    {{ number_format($item->total_price, 0, ',', ' ') }} F CFA
                                </td>
                            </tr>
                            @endforeach

                            {{-- Totaux --}}
                            @if($order->discount_amount > 0)
                            <tr>
                                <td style="padding:10px 20px;font-size:13px;color:#888888;">Sous-total</td>
                                <td style="padding:10px 20px;text-align:right;font-size:13px;color:#555555;">{{ number_format($order->subtotal, 0, ',', ' ') }} F CFA</td>
                            </tr>
                            <tr>
                                <td style="padding:4px 20px;font-size:13px;color:#27ae60;">Réduction</td>
                                <td style="padding:4px 20px;text-align:right;font-size:13px;color:#27ae60;">−{{ number_format($order->discount_amount, 0, ',', ' ') }} F CFA</td>
                            </tr>
                            @endif
                            <tr style="background:#111111;">
                                <td style="padding:16px 20px;font-size:15px;font-weight:700;color:#ffffff;">Total</td>
                                <td style="padding:16px 20px;text-align:right;font-size:17px;font-weight:800;color:#e8ff47;">{{ number_format($order->total, 0, ',', ' ') }} F CFA</td>
                            </tr>
                        </table>

                        {{-- Adresse --}}
                        @if($order->address)
                        <table width="100%" cellpadding="0" cellspacing="0" style="background:#f9f9f9;border:1px solid #e5e5e5;border-radius:10px;margin-bottom:28px;">
                            <tr>
                                <td style="padding:20px 24px;">
                                    <div style="font-size:12px;color:#888888;text-transform:uppercase;letter-spacing:1px;margin-bottom:8px;">Adresse de livraison</div>
                                    <div style="font-size:14px;color:#333333;line-height:1.8;">
                                        <strong>{{ $order->address->full_name }}</strong><br>
                                        {{ $order->address->phone }}<br>
                                        {{ $order->address->address_line }}{{ $order->address->quartier ? ', ' . $order->address->quartier : '' }}<br>
                                        {{ $order->address->city }}
                                    </div>
                                </td>
                            </tr>
                        </table>
                        @endif

                        {{-- CTA --}}
                        <div style="text-align:center;margin-bottom:32px;">
                            <a href="{{ route('shop.commandes.show', $order) }}"
                               style="display:inline-block;background:#111111;color:#e8ff47;text-decoration:none;font-weight:700;font-size:15px;padding:14px 32px;border-radius:8px;">
                                Suivre ma commande →
                            </a>
                        </div>

                        <p style="margin:0;font-size:13px;color:#888888;line-height:1.6;">
                            Vous serez notifié par e-mail dès que votre commande sera confirmée par notre équipe.<br>
                            Pour toute question, contactez-nous via notre site.
                        </p>

                    </td>
                </tr>

                {{-- Footer --}}
                <tr>
                    <td style="background:#111111;border-radius:0 0 12px 12px;padding:24px 40px;text-align:center;">
                        <p style="margin:0;font-size:12px;color:#666666;">
                            © {{ date('Y') }} NSPV Informatique · Tous droits réservés
                        </p>
                        <p style="margin:8px 0 0;font-size:11px;color:#555555;">
                            Vous recevez cet e-mail car vous avez passé une commande sur notre boutique.
                        </p>
                    </td>
                </tr>

            </table>
        </td>
    </tr>
</table>

</body>
</html>
