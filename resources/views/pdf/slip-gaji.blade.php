<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Slip Gaji - {{ $data->employee->name }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 13px;
            color: #1e293b;
            background: #fff;
            padding: 40px;
        }

        /* Header */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            border-bottom: 3px solid #4f46e5;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }

        .company-name {
            font-size: 22px;
            font-weight: 800;
            color: #0f172a;
            letter-spacing: 1px;
        }

        .company-sub {
            font-size: 11px;
            color: #64748b;
            margin-top: 2px;
        }

        .slip-title {
            text-align: right;
        }

        .slip-title h2 {
            font-size: 16px;
            font-weight: 700;
            color: #4f46e5;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .slip-title .period {
            font-size: 12px;
            color: #64748b;
            margin-top: 4px;
        }

        /* Info Grid */
        .info-grid {
            display: table;
            width: 100%;
            margin-bottom: 30px;
        }

        .info-row {
            display: table-row;
        }

        .info-label {
            display: table-cell;
            padding: 6px 20px 6px 0;
            font-size: 12px;
            color: #64748b;
            font-weight: 600;
            width: 140px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .info-value {
            display: table-cell;
            padding: 6px 0;
            font-size: 13px;
            color: #0f172a;
            font-weight: 500;
        }

        /* Salary Table */
        .salary-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
        }

        .salary-table thead th {
            background: #f1f5f9;
            padding: 10px 16px;
            font-size: 11px;
            font-weight: 700;
            color: #475569;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 2px solid #e2e8f0;
        }

        .salary-table thead th:last-child {
            text-align: right;
        }

        .salary-table tbody td {
            padding: 12px 16px;
            border-bottom: 1px solid #f1f5f9;
            font-size: 13px;
        }

        .salary-table tbody td:last-child {
            text-align: right;
            font-weight: 600;
            font-variant-numeric: tabular-nums;
        }

        .salary-table .addition td:last-child {
            color: #059669;
        }

        .salary-table .deduction td:last-child {
            color: #dc2626;
        }

        .salary-table .total-row {
            background: #4f46e5;
        }

        .salary-table .total-row td {
            padding: 14px 16px;
            color: #fff;
            font-weight: 700;
            font-size: 14px;
            border: none;
        }

        .salary-table .total-row td:last-child {
            font-size: 18px;
            color: #fff;
        }

        /* Footer */
        .footer {
            margin-top: 50px;
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
        }

        .footer-left {
            font-size: 10px;
            color: #94a3b8;
        }

        .signature {
            text-align: center;
            width: 200px;
        }

        .signature .line {
            border-top: 1px solid #cbd5e1;
            margin-top: 60px;
            padding-top: 8px;
        }

        .signature .label {
            font-size: 12px;
            color: #475569;
            font-weight: 600;
        }

        .signature .sublabel {
            font-size: 11px;
            color: #94a3b8;
        }

        /* Watermark-like confidential */
        .confidential {
            text-align: center;
            font-size: 10px;
            color: #cbd5e1;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-top: 30px;
            padding-top: 15px;
            border-top: 1px solid #f1f5f9;
        }
    </style>
</head>
<body>

    <!-- Header -->
    <div class="header">
        <div>
            <div class="company-name">KODAKARSA CORPS</div>
            <div class="company-sub">Human Resources & Payroll Division</div>
        </div>
        <div class="slip-title">
            <h2>Slip Gaji</h2>
            <div class="period">Periode: {{ $data->month_year }}</div>
        </div>
    </div>

    <!-- Employee Info -->
    <div class="info-grid">
        <div class="info-row">
            <div class="info-label">NIK</div>
            <div class="info-value">{{ $data->employee->nik }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Nama</div>
            <div class="info-value">{{ $data->employee->name }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Jabatan</div>
            <div class="info-value">{{ $data->employee->position }}</div>
        </div>
    </div>

    <!-- Salary Breakdown -->
    <table class="salary-table">
        <thead>
            <tr>
                <th>Komponen</th>
                <th>Nominal</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Gaji Pokok</td>
                <td>Rp {{ number_format($data->basic_salary, 0, ',', '.') }}</td>
            </tr>
            <tr class="addition">
                <td>Tunjangan (Transportasi, Makan, dll)</td>
                <td>+ Rp {{ number_format($data->allowance, 0, ',', '.') }}</td>
            </tr>
            <tr class="deduction">
                <td>Potongan (BPJS, Pajak, dll)</td>
                <td>− Rp {{ number_format($data->deduction, 0, ',', '.') }}</td>
            </tr>
            <tr class="total-row">
                <td>TAKE HOME PAY</td>
                <td>Rp {{ number_format($data->net_salary, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <!-- Footer -->
    <div class="footer">
        <div class="footer-left">
            Diterbitkan: {{ now()->locale('id')->isoFormat('D MMMM YYYY, HH:mm') }} WIB<br>
            Dokumen ini digenerate secara otomatis oleh sistem payroll.
        </div>
        <div class="signature">
            <div class="line">
                <div class="label">Manajer HRD</div>
                <div class="sublabel">Kodakarsa Corps</div>
            </div>
        </div>
    </div>

    <div class="confidential">
        Dokumen Rahasia — Hanya untuk penerima yang bersangkutan
    </div>

</body>
</html>