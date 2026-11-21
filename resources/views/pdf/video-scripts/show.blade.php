<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <title>{{ $script->title }}</title>

    <style>
        @page {
            margin: 20mm 18mm 25mm 18mm;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: DejaVu Sans, sans-serif;
            font-size: 10pt;
            line-height: 1.65;
            color: #263044;
        }

        .layout {
            width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
        }

        .layout td {
            padding: 0;
            margin: 0;
            text-align: left;
            vertical-align: top;
        }

        .header {
            width: 100%;
            padding-bottom: 18px !important;
            margin-bottom: 28px;
            border-bottom: 3px solid #5541f0;
        }

        .brand {
            font-size: 19pt;
            font-weight: bold;
            color: #5541f0;
            margin: 0;
            padding: 0;
        }

        .document-label {
            font-size: 8pt;
            color: #7b8495;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            margin-top: 4px;
        }

        .script-title {
            font-size: 23pt;
            line-height: 1.3;
            font-weight: bold;
            color: #172033;
            margin: 0 0 8px 0;
            padding: 0;
        }

        .platforms {
            color: #5541f0;
            font-size: 9pt;
            font-weight: bold;
            margin: 0 0 24px 0;
        }

        .metadata {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
            margin-bottom: 30px;
        }

        .metadata td {
            width: 50%;
            padding: 10px 12px;
            border: 1px solid #e5e7eb;
            text-align: center;
        }

        .metadata-label {
            display: block;
            font-size: 7.5pt;
            color: #7b8495;
            text-transform: uppercase;
            letter-spacing: 0.7px;
            margin-bottom: 3px;
        }

        .metadata-value {
            font-size: 9pt;
            font-weight: bold;
            color: #263044;
        }

        .content-heading {
            font-size: 14pt;
            font-weight: bold;
            color: #172033;
            border-bottom: 2px solid #5541f0;
            padding-bottom: 7px;
            margin-bottom: 18px;
        }

        .script-content {
            width: 100%;
            font-size: 10pt;
            line-height: 1.75;
            margin: 0;
            padding: 0;
            text-align: left !important;
            overflow-wrap: break-word;
        }

        .script-content * {
            text-align: left !important;
        }

        .script-content h1,
        .script-content h2,
        .script-content h3,
        .script-content h4 {
            color: #172033;
            line-height: 1.4;
            page-break-after: avoid;
        }

        .script-content h1 {
            font-size: 17pt;
            margin-top: 24px;
            margin-bottom: 10px;
        }

        .script-content h2 {
            font-size: 14pt;
            margin-top: 22px;
            margin-bottom: 9px;
        }

        .script-content h3 {
            font-size: 11pt;
            margin-top: 18px;
            margin-bottom: 7px;
        }

        .script-content p {
            margin-top: 0;
            margin-bottom: 12px;
        }

        .script-content ul,
        .script-content ol {
            margin-top: 8px;
            margin-bottom: 14px;
            padding-left: 24px;
        }

        .script-content li {
            margin-bottom: 5px;
        }

        .script-content blockquote {
            border-left: 3px solid #5541f0;
            padding-left: 14px;
            margin-left: 0;
            color: #596579;
        }

        .script-content a {
            color: #5541f0;
            text-decoration: underline;
        }

        .script-content img {
            max-width: 100%;
            height: auto;
        }

        .page-number:after {
            content: counter(page);
        }

        .page-count:after {
            content: counter(pages);
        }
    </style>
</head>

<body>

    <table class="layout" width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td align="left">

                <table width="100%" cellpadding="0" cellspacing="0">
                    <tr>
                        <td align="left" class="header">
                            <div class="brand">PkmnNexus</div>
                            <div class="document-label">Video Script</div>
                        </td>
                    </tr>

                    <tr>
                        <td align="left">
                            <div class="script-title">
                                {{ $script->title }}
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td align="left">
                            <div class="platforms">
                                {{ implode(' · ', $platformLabels) }}
                            </div>
                        </td>
                    </tr>
                </table>

                <table class="metadata" width="100%" cellpadding="0" cellspacing="0">
                    <tr>
                        <td>
                            <span class="metadata-label">Category</span>
                            <span class="metadata-value">
                                {{ $script->category?->name ?? '-' }}
                            </span>
                        </td>

                        <td>
                            <span class="metadata-label">Published At</span>
                            <span class="metadata-value">
                                {{ $script->published_at?->locale('en')->translatedFormat('F j, Y') ?? '-' }}
                            </span>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <span class="metadata-label">Word Count</span>
                            <span class="metadata-value">
                                {{ number_format($script->word_count) }}
                            </span>
                        </td>

                        <td>
                            <span class="metadata-label">Estimated Duration</span>
                            <span class="metadata-value">
                                {{ $estimatedDuration }}
                            </span>
                        </td>
                    </tr>
                </table>

                <table width="100%" cellpadding="0" cellspacing="0">
                    <tr>
                        <td align="left">
                            <div class="content-heading">Script</div>
                        </td>
                    </tr>

                    <tr>
                        <td align="left">
                            <div class="script-content">
                                {!! $script->content !!}
                            </div>
                        </td>
                    </tr>
                </table>

            </td>
        </tr>
    </table>

</body>
</html>