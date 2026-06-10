<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Commande livrée — Donnez votre avis</title>
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

                {{-- Bannière livraison --}}
                <tr>
                    <td style="background:#1565c0;padding:24px 40px;text-align:center;">
                        <div style="font-size:36px;margin-bottom:10px;">📦</div>
                        <div style="font-size:18px;font-weight:800;color:#ffffff;">Votre commande est livrée !</div>
                        <div style="font-size:13px;color:#90caf9;margin-top:6px;">Commande {{ $order->order_number }}</div>
                    </td>
                </tr>

                {{-- Body --}}
                <tr>
                    <td style="background:#ffffff;padding:40px;">

                        <p style="margin:0 0 8px;font-size:15px;color:#555555;line-height:1.6;">
                            Bonjour <strong>{{ $order->user->name }}</strong>,<br>
                            Votre commande <strong>{{ $order->order_number }}</strong> a bien été livrée.
                            Nous espérons qu'elle vous donne entière satisfaction !
                        </p>
                        <p style="margin:0 0 32px;font-size:15px;color:#555555;line-height:1.6;">
                            Votre avis compte beaucoup pour nous et aide les autres clients à faire leur choix.
                            Prenez quelques secondes pour noter vos produits 👇
                        </p>

                        {{-- Invitation par produit --}}
                        <div style="font-size:14px;font-weight:700;color:#111111;margin-bottom:16px;text-transform:uppercase;letter-spacing:0.5px;">Notez vos produits</div>

                        @foreach($order->items as $item)
                        <table width="100%" cellpadding="0" cellspacing="0" style="border:1px solid #e5e5e5;border-radius:10px;margin-bottom:12px;overflow:hidden;">
                            <tr>
                                <td style="padding:16px 20px;">
                                    <div style="font-size:15px;font-weight:700;color:#111111;margin-bottom:4px;">{{ $item->product_name }}</div>
                                    <div style="font-size:12px;color:#888888;margin-bottom:12px;">{{ $item->quantity }} unité{{ $item->quantity > 1 ? 's' : '' }} commandée{{ $item->quantity > 1 ? 's' : '' }}</div>
                                    <div style="font-size:22px;color:#dddddd;letter-spacing:4px;margin-bottom:12px;">★★★★★</div>
                                    <a href="{{ route('shop.commandes.show', $order) }}"
                                       style="display:inline-block;background:#e8ff47;color:#111111;text-decoration:none;font-weight:700;font-size:13px;padding:10px 22px;border-radius:7px;">
                                        Donner mon avis
                                    </a>
                                </td>
                            </tr>
                        </table>
                        @endforeach

                        <div style="margin:32px 0;border-top:1px solid #f0f0f0;"></div>

                        {{-- CTA principal --}}
                        <div style="text-align:center;margin-bottom:32px;">
                            <p style="font-size:14px;color:#555555;margin:0 0 16px;">
                                Retrouvez tous vos avis directement sur votre commande :
                            </p>
                            <a href="{{ route('shop.commandes.show', $order) }}"
                               style="display:inline-block;background:#111111;color:#e8ff47;text-decoration:none;font-weight:700;font-size:15px;padding:14px 32px;border-radius:8px;">
                                Voir ma commande & laisser mes avis →
                            </a>
                        </div>

                        <p style="margin:0;font-size:13px;color:#888888;line-height:1.6;text-align:center;">
                            Merci d'avoir choisi NSPV Informatique.<br>
                            Nous espérons vous revoir bientôt !
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
