<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Commande confirmée</title>
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

                {{-- Bannière statut --}}
                <tr>
                    <td style="background:#1a6b3a;padding:20px 40px;text-align:center;">
                        <div style="font-size:32px;margin-bottom:8px;">🎉</div>
                        <div style="font-size:18px;font-weight:800;color:#ffffff;">Commande confirmée !</div>
                        <div style="font-size:13px;color:#a8e6c0;margin-top:4px;">Votre commande a été validée par notre équipe</div>
                    </td>
                </tr>

                {{-- Body --}}
                <tr>
                    <td style="background:#ffffff;padding:40px;">

                        <p style="margin:0 0 28px;font-size:15px;color:#555555;line-height:1.6;">
                            Bonjour <strong>{{ $order->user->name }}</strong>,<br>
                            Bonne nouvelle ! Notre équipe a bien validé votre commande. Nous allons maintenant préparer votre colis.
                        </p>

                        {{-- Numéro de commande --}}
                        <table width="100%" cellpadding="0" cellspacing="0" style="background:#f9f9f9;border:1px solid #e5e5e5;border-radius:10px;margin-bottom:28px;">
                            <tr>
                                <td style="padding:20px 24px;">
                                    <div style="font-size:12px;color:#888888;text-transform:uppercase;letter-spacing:1px;margin-bottom:4px;">Numéro de commande</div>
                                    <div style="font-size:20px;font-weight:800;color:#111111;letter-spacing:1px;">{{ $order->order_number }}</div>
                                    <div style="font-size:13px;color:#888888;margin-top:6px;">Passée le {{ $order->created_at->format('d/m/Y') }}</div>
                                </td>
                                <td style="padding:20px 24px;text-align:right;vertical-align:middle;">
                                    <span style="display:inline-block;background:#e8f5e9;color:#1a6b3a;border:1px solid #a8e6c0;padding:6px 16px;border-radius:20px;font-size:13px;font-weight:700;">
                                        ✓ Confirmée
                                    </span>
                                </td>
                            </tr>
                        </table>

                        {{-- Articles --}}
                        <div style="font-size:14px;font-weight:700;color:#111111;margin-bottom:12px;text-transform:uppercase;letter-spacing:0.5px;">Récapitulatif</div>
                        <table width="100%" cellpadding="0" cellspacing="0" style="border:1px solid #e5e5e5;border-radius:10px;overflow:hidden;margin-bottom:24px;">
                            @foreach($order->items as $item)
                            <tr>
                                <td style="padding:14px 20px;font-size:14px;color:#333333;border-bottom:1px solid #f0f0f0;">
                                    <div style="font-weight:600;">{{ $item->product_name }}</div>
                                    <div style="color:#888888;font-size:12px;margin-top:3px;">{{ $item->quantity }} × {{ number_format($item->unit_price, 0, ',', ' ') }} F CFA</div>
                                </td>
                                <td style="padding:14px 20px;text-align:right;font-size:14px;font-weight:700;color:#111111;white-space:nowrap;border-bottom:1px solid #f0f0f0;">
                                    {{ number_format($item->total_price, 0, ',', ' ') }} F CFA
                                </td>
                            </tr>
                            @endforeach
                            <tr style="background:#111111;">
                                <td style="padding:16px 20px;font-size:15px;font-weight:700;color:#ffffff;">Total</td>
                                <td style="padding:16px 20px;text-align:right;font-size:17px;font-weight:800;color:#e8ff47;">{{ number_format($order->total, 0, ',', ' ') }} F CFA</td>
                            </tr>
                        </table>

                        {{-- Étapes --}}
                        <div style="font-size:14px;font-weight:700;color:#111111;margin-bottom:16px;text-transform:uppercase;letter-spacing:0.5px;">Prochaines étapes</div>
                        <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:32px;">
                            <tr>
                                <td style="padding:10px 0;vertical-align:top;width:40px;">
                                    <div style="width:28px;height:28px;background:#e8ff47;border-radius:50%;text-align:center;line-height:28px;font-weight:800;font-size:13px;color:#111111;">1</div>
                                </td>
                                <td style="padding:10px 0 10px 12px;vertical-align:top;">
                                    <div style="font-size:14px;font-weight:600;color:#111111;">Préparation de votre commande</div>
                                    <div style="font-size:13px;color:#888888;">Notre équipe prépare vos articles avec soin.</div>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding:10px 0;vertical-align:top;">
                                    <div style="width:28px;height:28px;background:#f0f0f0;border-radius:50%;text-align:center;line-height:28px;font-weight:800;font-size:13px;color:#888888;">2</div>
                                </td>
                                <td style="padding:10px 0 10px 12px;vertical-align:top;">
                                    <div style="font-size:14px;font-weight:600;color:#888888;">
                                        @if($order->delivery_type === 'pickup')
                                            Disponible en boutique
                                        @else
                                            Expédition & livraison
                                        @endif
                                    </div>
                                    <div style="font-size:13px;color:#aaaaaa;">
                                        @if($order->delivery_type === 'pickup')
                                            Vous serez contacté quand votre commande sera prête à récupérer.
                                        @else
                                            Votre colis sera expédié à votre adresse de livraison.
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        </table>

                        {{-- CTA --}}
                        <div style="text-align:center;margin-bottom:32px;">
                            <a href="{{ route('shop.commandes.show', $order) }}"
                               style="display:inline-block;background:#111111;color:#e8ff47;text-decoration:none;font-weight:700;font-size:15px;padding:14px 32px;border-radius:8px;">
                                Voir ma commande →
                            </a>
                        </div>

                        <p style="margin:0;font-size:13px;color:#888888;line-height:1.6;">
                            Vous recevrez un autre e-mail une fois votre commande livrée.
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
