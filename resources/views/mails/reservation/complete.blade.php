<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" style="outline: 0; font-weight: inherit; font-style: inherit; vertical-align: baseline; box-sizing: border-box; margin: 0; padding: 0; border: 0;">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="format-detection">

    <title>{!! __('front.reservation.mails.complete.title') !!}</title>
</head>

<body style="font-family: sans-serif; outline: 0; font-weight: inherit; font-style: inherit; vertical-align: baseline; box-sizing: border-box; margin: 0; padding: 0; border: 0;">

    <div style="width: 100%; max-width: 700px; outline: 0; font-weight: inherit; font-style: inherit; vertical-align: baseline; box-sizing: border-box; margin: 0; padding: 0; border: 0;">
        <table cellpadding="0" cellspacing="0" style="outline: 0; font-weight: inherit; font-style: inherit; vertical-align: baseline; box-sizing: border-box; margin: 0; padding: 0; border: 0; width: 100%; border-collapse: collapse; border-spacing: 0;">
            <thead style="outline: 0; font-weight: inherit; font-style: inherit; vertical-align: baseline; box-sizing: border-box; margin: 0; padding: 0; border: 0;">
                <tr style="outline: 0; font-weight: inherit; font-style: inherit; vertical-align: baseline; box-sizing: border-box; margin: 0; padding: 0; border: 0;">
                    <td style="outline: 0; font-weight: inherit; font-style: inherit; vertical-align: baseline; box-sizing: border-box; margin: 0; padding: 0 0 48px; border: 0;">
                        <a href="{{ route('ko.index') }}" target="_blank" style="outline: 0; font-weight: inherit; font-style: inherit; vertical-align: baseline; box-sizing: border-box; margin: 0; padding: 0; border: 0;">
                            <span style="outline: 0; font-weight: inherit; font-style: inherit; vertical-align: baseline; box-sizing: border-box; margin: 0; padding: 0; border: 0; display: block; width: 100%; max-width: 251px;">
                                <img src="{{ asset('/assets/front/images/mails/logo.png') }}" alt="Médongaule" style="outline: 0; font-weight: inherit; font-style: inherit; vertical-align: baseline; box-sizing: border-box; margin: 0; padding: 0; border: 0;" />
                            </span>
                        </a>
                    </td>
                </tr>
            </thead>
            <tbody style="outline: 0; font-weight: inherit; font-style: inherit; vertical-align: baseline; box-sizing: border-box; margin: 0; padding: 0; border: 0;">
                <tr style="outline: 0; font-weight: inherit; font-style: inherit; vertical-align: baseline; box-sizing: border-box; margin: 0; padding: 0; border: 0;">
                    <td style="outline: 0; font-weight: inherit; font-style: inherit; vertical-align: baseline; box-sizing: border-box; margin: 0; padding: 0; border: 0;">
                        <table cellpadding="0" cellspacing="0" style="outline: 0; font-weight: inherit; font-style: inherit; vertical-align: baseline; box-sizing: border-box; margin: 0; padding: 0; border: 0; width: 100%; border-collapse: collapse; border-spacing: 0;">
                            <tr style="outline: 0; font-weight: inherit; font-style: inherit; vertical-align: baseline; box-sizing: border-box; margin: 0; padding: 0; border: 0;">
                                <td style="outline: 0; font-weight: 600; font-style: inherit; vertical-align: baseline; box-sizing: border-box; margin: 0; padding: 0; border: 0; font-size: 36px; line-height: 48px; letter-spacing: 0; color: #000;">
                                    {!! __('front.reservation.mails.complete.title') !!}
                                </td>
                            </tr>
                            <tr style="outline: 0; font-weight: inherit; font-style: inherit; vertical-align: baseline; box-sizing: border-box; margin: 0; padding: 0; border: 0;">
                                <td style="outline: 0; font-weight: 500; font-style: inherit; vertical-align: baseline; box-sizing: border-box; margin: 0; padding: 10px 0 0; border: 0; font-size: 18px; line-height: 28px; letter-spacing: 0; color: #666;">
                                    {!! __('front.reservation.mails.complete.desc') !!}
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr style="outline: 0; font-weight: inherit; font-style: inherit; vertical-align: baseline; box-sizing: border-box; margin: 0; padding: 0; border: 0;">
                    <td style="outline: 0; font-weight: inherit; font-style: inherit; vertical-align: baseline; box-sizing: border-box; margin: 0; padding: 48px 0 0; border: 0;">
                        <table cellpadding="0" cellspacing="0" style="outline: 0; font-weight: inherit; font-style: inherit; vertical-align: baseline; box-sizing: border-box; margin: 0; padding: 0; border: 0; width: 100%; border-collapse: collapse; border-spacing: 0; border-top: 1px solid #000;">
                            <tr style="outline: 0; font-weight: inherit; font-style: inherit; vertical-align: baseline; box-sizing: border-box; margin: 0; padding: 0; border: 0;">
                                <th style="outline: 0; font-weight: 500; font-style: inherit; vertical-align: middle; box-sizing: border-box; margin: 0; padding: 24px 8px; border: 0; font-size: 16px; line-height: 24px; letter-spacing: 0; color: #000; text-align: center; background-color: #f8f8f8; border-bottom: 1px solid #ddd; width: 25.71%;">
                                    {!! __('front.reservation.mails.label.number') !!}
                                </th>
                                <td style="outline: 0; font-weight: 500; font-style: inherit; vertical-align: middle; box-sizing: border-box; margin: 0; padding: 24px 8px 24px 24px; border: 0; font-size: 16px; line-height: 24px; letter-spacing: 0; font-weight: 500; color: #666; border-bottom: 1px solid #ddd;">
                                    {{ $reservation->code }}
                                </td>
                            </tr>
                            <tr style="outline: 0; font-weight: inherit; font-style: inherit; vertical-align: baseline; box-sizing: border-box; margin: 0; padding: 0; border: 0;">
                                <th style="outline: 0; font-weight: 500; font-style: inherit; vertical-align: middle; box-sizing: border-box; margin: 0; padding: 24px 8px; border: 0; font-size: 16px; line-height: 24px; letter-spacing: 0; color: #000; text-align: center; background-color: #f8f8f8; border-bottom: 1px solid #ddd; width: 25.71%;">
                                    {!! __('front.reservation.mails.label.date') !!}
                                </th>
                                <td style="outline: 0; font-weight: 500; font-style: inherit; vertical-align: middle; box-sizing: border-box; margin: 0; padding: 24px 8px 24px 24px; border: 0; font-size: 16px; line-height: 24px; letter-spacing: 0; font-weight: 500; color: #666; border-bottom: 1px solid #ddd;">
                                    {{ 'en' === app()->getLocale() ? $reservation->select_date->format('l, F j, y') : date_format_korean($reservation->select_date, 'Y년 n월 j일(D)') }}
                                </td>
                            </tr>
                            <tr style="outline: 0; font-weight: inherit; font-style: inherit; vertical-align: baseline; box-sizing: border-box; margin: 0; padding: 0; border: 0;">
                                <th style="outline: 0; font-weight: 500; font-style: inherit; vertical-align: middle; box-sizing: border-box; margin: 0; padding: 24px 8px; border: 0; font-size: 16px; line-height: 24px; letter-spacing: 0; color: #000; text-align: center; background-color: #f8f8f8; border-bottom: 1px solid #ddd; width: 25.71%;">
                                    {!! __('front.reservation.mails.label.time') !!}
                                </th>
                                <td style="outline: 0; font-weight: 500; font-style: inherit; vertical-align: middle; box-sizing: border-box; margin: 0; padding: 24px 8px 24px 24px; border: 0; font-size: 16px; line-height: 24px; letter-spacing: 0; font-weight: 500; color: #666; border-bottom: 1px solid #ddd;">
                                    {{ 'en' === app()->getLocale() ? $reservation->select_time->format('A h:i') : date_format_korean($reservation->select_time, 'A h:i') }}{{ $reservation->use_docent ? '(' . __('front.reservation.mails.docent') . ')' : '' }}
                                </td>
                            </tr>
                            <tr style="outline: 0; font-weight: inherit; font-style: inherit; vertical-align: baseline; box-sizing: border-box; margin: 0; padding: 0; border: 0;">
                                <th style="outline: 0; font-weight: 500; font-style: inherit; vertical-align: middle; box-sizing: border-box; margin: 0; padding: 24px 8px; border: 0; font-size: 16px; line-height: 24px; letter-spacing: 0; color: #000; text-align: center; background-color: #f8f8f8; border-bottom: 1px solid #ddd; width: 25.71%;">
                                    {!! __('front.reservation.mails.label.visitor') !!}
                                </th>
                                <td style="outline: 0; font-weight: 500; font-style: inherit; vertical-align: middle; box-sizing: border-box; margin: 0; padding: 24px 8px 24px 24px; border: 0; font-size: 16px; line-height: 24px; letter-spacing: 0; font-weight: 500; color: #666; border-bottom: 1px solid #ddd;">
                                    {{ $reservation->get_visitors_label() }}
                                </td>
                            </tr>
                            <tr style="outline: 0; font-weight: inherit; font-style: inherit; vertical-align: baseline; box-sizing: border-box; margin: 0; padding: 0; border: 0;">
                                <th style="outline: 0; font-weight: 500; font-style: inherit; vertical-align: middle; box-sizing: border-box; margin: 0; padding: 24px 8px; border: 0; font-size: 16px; line-height: 24px; letter-spacing: 0; color: #000; text-align: center; background-color: #f8f8f8; border-bottom: 1px solid #ddd; width: 25.71%;">
                                    {!! __('front.reservation.mails.label.type') !!}
                                </th>
                                <td style="outline: 0; font-weight: 500; font-style: inherit; vertical-align: middle; box-sizing: border-box; margin: 0; padding: 24px 8px 24px 24px; border: 0; font-size: 16px; line-height: 24px; letter-spacing: 0; font-weight: 500; color: #666; border-bottom: 1px solid #ddd;">
                                    {{ $reservation->get_payment_type() }}
                                </td>
                            </tr>
                            <tr style="outline: 0; font-weight: inherit; font-style: inherit; vertical-align: baseline; box-sizing: border-box; margin: 0; padding: 0; border: 0;">
                                <th style="outline: 0; font-weight: 500; font-style: inherit; vertical-align: middle; box-sizing: border-box; margin: 0; padding: 24px 8px; border: 0; font-size: 16px; line-height: 24px; letter-spacing: 0; color: #000; text-align: center; background-color: #f8f8f8; border-bottom: 1px solid #ddd; width: 25.71%;">
                                    {!! __('front.reservation.mails.label.amount') !!}
                                </th>
                                <td style="outline: 0; font-weight: 500; font-style: inherit; vertical-align: middle; box-sizing: border-box; margin: 0; padding: 24px 8px 24px 24px; border: 0; font-size: 16px; line-height: 24px; letter-spacing: 0; font-weight: 500; color: #666; border-bottom: 1px solid #ddd;">
                                    {!! __('front.reservation.common.price', ['PRICE'=>number_format($reservation->amount)]) !!}
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr style="outline: 0; font-weight: inherit; font-style: inherit; vertical-align: baseline; box-sizing: border-box; margin: 0; padding: 0; border: 0;">
                    <td style="outline: 0; font-weight: inherit; font-style: inherit; vertical-align: baseline; box-sizing: border-box; margin: 0; padding: 24px 16px 0; border: 0;">
                        <table cellpadding="0" cellspacing="0" style="outline: 0; font-weight: inherit; font-style: inherit; vertical-align: baseline; box-sizing: border-box; margin: 0; padding: 0; border: 0; width: 100%; border-collapse: collapse; border-spacing: 0;">
                            @foreach ( __('front.reservation.mails.warning') as $desc )
                                <tr style="outline: 0; font-weight: inherit; font-style: inherit; vertical-align: baseline; box-sizing: border-box; margin: 0; padding: 0; border: 0;">
                                    <td style="outline: 0; font-weight: inherit; font-style: inherit; vertical-align: baseline; box-sizing: border-box; margin: 0; padding: 0; border: 0; font-size: 16px; line-height: 24px; width: 12px;">
                                        <span style="outline: 0; font-weight: inherit; font-style: inherit; vertical-align: baseline; box-sizing: border-box; margin: 0; padding: 0; border: 0; display: table; height: 24px;">
                                            <span style="outline: 0; font-weight: inherit; font-style: inherit; box-sizing: border-box; margin: 0; padding: 0; border: 0; display: table-cell; vertical-align: middle;">
                                                <i style="outline: 0; font-weight: inherit; font-style: inherit; vertical-align: baseline; box-sizing: border-box; margin: 0; padding: 0; border: 0; display: block; width: 4px; height: 4px; border-radius: 50%; background-color: #666;"></i>
                                            </span>
                                        </span>
                                    </td>
                                    <td style="outline: 0; font-weight: 500; font-style: inherit; vertical-align: top; box-sizing: border-box; margin: 0; padding: 0 0 8px; border: 0; font-size: 16px; line-height: 24px; letter-spacing: 0; color: #666;">
                                        {!! $desc !!}
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </td>
                </tr>
                <tr style="outline: 0; font-weight: inherit; font-style: inherit; vertical-align: baseline; box-sizing: border-box; margin: 0; padding: 0; border: 0;">
                    <td style="outline: 0; font-weight: inherit; font-style: inherit; vertical-align: baseline; box-sizing: border-box; margin: 0; padding: 48px 0 80px; border: 0;">
                        <div style="outline: 0; font-weight: inherit; font-style: inherit; vertical-align: baseline; box-sizing: border-box; margin: 0; padding: 32px; border: 0; background-color: #f8f8f8;">
                            <table cellpadding="0" cellspacing="0" style="outline: 0; font-weight: inherit; font-style: inherit; vertical-align: baseline; box-sizing: border-box; margin: 0; padding: 0; border: 0; width: 100%; border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <tr style="outline: 0; font-weight: inherit; font-style: inherit; vertical-align: baseline; box-sizing: border-box; margin: 0; padding: 0; border: 0;">
                                    <td style="outline: 0; font-weight: 600; font-style: inherit; vertical-align: baseline; box-sizing: border-box; margin: 0; padding: 0 0 12px; border: 0; font-size: 18px; line-height: 28px; letter-spacing: 0; color: #000;">
                                        {!! __('front.reservation.mails.refund.label') !!}
                                    </td>
                                </tr>
                                <tr style="outline: 0; font-weight: inherit; font-style: inherit; vertical-align: baseline; box-sizing: border-box; margin: 0; padding: 0; border: 0;">
                                    <td style="outline: 0; font-weight: inherit; font-style: inherit; vertical-align: baseline; box-sizing: border-box; margin: 0; padding: 0; border: 0;">
                                        <table cellpadding="0" cellspacing="0" style="outline: 0; font-weight: inherit; font-style: inherit; vertical-align: baseline; box-sizing: border-box; margin: 0; padding: 0; border: 0; width: 100%; border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            @foreach ( __('front.reservation.mails.refund.desc') as $desc )
                                                <tr style="outline: 0; font-weight: inherit; font-style: inherit; vertical-align: baseline; box-sizing: border-box; margin: 0; padding: 0; border: 0;">
                                                    <td style="outline: 0; font-weight: inherit; font-style: inherit; vertical-align: baseline; box-sizing: border-box; margin: 0; padding: 0; border: 0; font-size: 16px; line-height: 24px; width: 12px;">
                                                        <span style="outline: 0; font-weight: inherit; font-style: inherit; vertical-align: baseline; box-sizing: border-box; margin: 0; padding: 0; border: 0; display: table; height: 24px;">
                                                            <span style="outline: 0; font-weight: inherit; font-style: inherit; box-sizing: border-box; margin: 0; padding: 0; border: 0; display: table-cell; vertical-align: middle;">
                                                                <i style="outline: 0; font-weight: inherit; font-style: inherit; vertical-align: baseline; box-sizing: border-box; margin: 0; padding: 0; border: 0; display: block; width: 4px; height: 4px; border-radius: 50%; background-color: #666;"></i>
                                                            </span>
                                                        </span>
                                                    </td>
                                                    <td style="outline: 0; font-weight: 500; font-style: inherit; vertical-align: top; box-sizing: border-box; margin: 0; padding: 0 0 8px; border: 0; font-size: 16px; line-height: 24px; letter-spacing: 0; color: #666;">
                                                        {!! $desc !!}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </td>
                </tr>
            </tbody>
            <tfoot style="outline: 0; font-weight: inherit; font-style: inherit; vertical-align: baseline; box-sizing: border-box; margin: 0; padding: 0; border: 0;">
                <tr style="outline: 0; font-weight: inherit; font-style: inherit; vertical-align: baseline; box-sizing: border-box; margin: 0; padding: 0; border: 0;">
                    <td style="outline: 0; font-weight: 500; font-style: inherit; vertical-align: baseline; box-sizing: border-box; margin: 0; padding: 40px 32px; border: 0; width: 100%; font-size: 14px; line-height: 20px; letter-spacing: 0; color: #666; text-align: center; background-color: #000;">
                        {!! __('front.reservation.mails.outgoing') !!}<br /><br />
                        © 2024 Médongaule. All Rights Reserved.
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</body>

</html>
