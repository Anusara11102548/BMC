<?php
declare(strict_types=1);
session_start();
$success = isset($_GET['sent']) && $_GET['sent'] === '1';
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require __DIR__ . '/config/database.php';
    $company = trim($_POST['company'] ?? '');
    $contact = trim($_POST['contact_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $type = $_POST['filter_type'] ?? 'custom';
    $reuse = $_POST['reuse_need'] ?? 'unsure';
    $temperature = $_POST['temperature'] ?? 'unknown';
    $chemical = $_POST['chemical_exposure'] ?? 'unknown';
    $target = trim($_POST['target_description'] ?? '');
    $allowedType = ['air','liquid','custom'];
    $allowedReuse = ['single','reusable','unsure'];
    $allowedTemp = ['normal','hot','unknown'];
    $allowedChemical = ['yes','no','unknown'];

    if ($contact === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'กรุณากรอกชื่อผู้ติดต่อและอีเมลให้ถูกต้อง';
    } elseif (!in_array($type, $allowedType, true) ||
              !in_array($reuse, $allowedReuse, true) ||
              !in_array($temperature, $allowedTemp, true) ||
              !in_array($chemical, $allowedChemical, true)) {
        $error = 'ข้อมูลบางช่องไม่ถูกต้อง กรุณาตรวจสอบอีกครั้ง';
    } else {
        $stmt = $pdo->prepare(
            'INSERT INTO inquiries
            (company, contact_name, email, phone, filter_type, reuse_need, temperature, chemical_exposure, target_description)
            VALUES (:company, :contact, :email, :phone, :type, :reuse, :temperature, :chemical, :target)'
        );
        $stmt->execute([
            ':company' => $company ?: null,
            ':contact' => $contact,
            ':email' => $email,
            ':phone' => $phone ?: null,
            ':type' => $type,
            ':reuse' => $reuse,
            ':temperature' => $temperature,
            ':chemical' => $chemical,
            ':target' => $target ?: null,
        ]);
        header('Location: index.php?sent=1#inquiry');
        exit;
    }
}
function e(string $value): string { return htmlspecialchars($value, ENT_QUOTES, 'UTF-8'); }
?>
<!doctype html>
<html lang="th">
<head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>FILTRATEX | Technical Filter Media</title>
<style>
:root{--bg:#f5f7f5;--paper:#fff;--ink:#172820;--muted:#62736a;--line:#dce5de;--green:#176b4a;--pale:#e8f2eb}
*{box-sizing:border-box}body{margin:0;background:var(--bg);color:var(--ink);font-family:Arial,"Noto Sans Thai",sans-serif;line-height:1.65}
.wrap{width:min(1100px,calc(100% - 32px));margin:auto}.nav{padding:20px 0;display:flex;justify-content:space-between;align-items:center;border-bottom:1px solid var(--line)}.logo{font-weight:900;letter-spacing:2px;font-size:22px}.logo span{color:var(--green)}a{color:var(--green);text-decoration:none}.hero{padding:65px 0;display:grid;grid-template-columns:1.2fr .8fr;gap:35px;align-items:center}.eyebrow{color:var(--green);font-weight:800;letter-spacing:2px;font-size:12px}.hero h1{font-size:clamp(36px,5vw,62px);line-height:1.08;margin:14px 0}.hero p,.muted{color:var(--muted)}.visual{min-height:270px;border-radius:22px;background:linear-gradient(140deg,#d5e8dc,#fff);border:1px solid var(--line);display:grid;place-items:center}.mesh{height:175px;width:175px;border:2px solid var(--green);border-radius:50%;background:repeating-linear-gradient(0deg,transparent 0 9px,#176b4a35 10px 11px),repeating-linear-gradient(90deg,transparent 0 9px,#176b4a35 10px 11px);transform:rotate(-12deg)}section{padding:44px 0}.cards{display:grid;grid-template-columns:repeat(3,1fr);gap:16px}.card,form{background:var(--paper);border:1px solid var(--line);border-radius:15px;padding:22px}.card h3{margin:7px 0}.code{color:var(--green);font-size:12px;font-weight:800}.layout{display:grid;grid-template-columns:.8fr 1.2fr;gap:24px;align-items:start}.fields{display:grid;grid-template-columns:1fr 1fr;gap:13px}.field{display:flex;flex-direction:column;gap:5px}.full{grid-column:1/-1}label{font-weight:bold;font-size:14px}input,select,textarea{padding:11px;border:1px solid var(--line);border-radius:8px;font:inherit;width:100%;background:white;color:#172820}textarea{min-height:90px}.btn{background:var(--green);color:white;border:0;border-radius:8px;padding:12px 18px;font-weight:bold;cursor:pointer}.notice{padding:13px 15px;border-radius:8px;margin:15px 0;background:var(--pale)}.err{background:#fff0ee;color:#9a271d}.footer{border-top:1px solid var(--line);padding:25px 0;color:var(--muted);font-size:13px}
@media(max-width:720px){.hero,.layout{grid-template-columns:1fr}.cards{grid-template-columns:1fr}.fields{grid-template-columns:1fr}.full{grid-column:auto}.hero{padding:40px 0}}
</style>
</head>
<body>
<header class="wrap nav"><a class="logo" href="#">FILTRA<span>TEX</span></a><nav><a href="#products">ผลิตภัณฑ์</a>　<a href="#process">กระบวนการ</a>　<a href="#inquiry">ติดต่อเรา</a></nav></header>
<main>
<div class="wrap hero"><div><div class="eyebrow">B2B TECHNICAL TEXTILE SUPPLIER</div><h1>วัสดุกรองที่ออกแบบ<br>เพื่ออุตสาหกรรม</h1><p>FILTRATEX พัฒนาแนวทางวัสดุกรองจากสิ่งทอตามการใช้งานของลูกค้า ครอบคลุมงานกรองอากาศ ของเหลว และงานเฉพาะทาง โดยประสานการทดสอบและการผลิตกับพันธมิตร</p><a class="btn" href="#inquiry">ส่งความต้องการของคุณ</a></div><div class="visual"><div class="mesh"></div></div></div>
<section id="products" class="wrap"><div class="eyebrow">PRODUCT RANGE</div><h2>ผลิตภัณฑ์ของเรา</h2><div class="cards">
<article class="card"><div class="code">FM-01 / AIR</div><h3>Air Filter Media</h3><p class="muted">แนวคิดวัสดุกรองอากาศและฝุ่นในงานอุตสาหกรรม</p></article>
<article class="card"><div class="code">FM-02 / LIQUID</div><h3>Liquid Filter Media</h3><p class="muted">แนวคิดวัสดุกรองน้ำและของเหลวในกระบวนการผลิต</p></article>
<article class="card"><div class="code">FM-03 / CUSTOM</div><h3>Custom Filter Media</h3><p class="muted">แนวทางพัฒนาวัสดุตามเงื่อนไขเฉพาะ เช่น ความร้อนหรือสารเคมี</p></article>
</div><p class="muted">หมายเหตุ: ประสิทธิภาพและสเปกจริงต้องยืนยันด้วยการทดสอบก่อนจำหน่าย</p></section>
<section id="process" class="wrap"><div class="eyebrow">OUR PROCESS</div><h2>กระบวนการทำงาน</h2><div class="cards"><article class="card"><h3>01. Requirement</h3><p class="muted">รับข้อมูลการใช้งานจากลูกค้า</p></article><article class="card"><h3>02. Material Design</h3><p class="muted">เลือกแนวทางวัสดุและกำหนดสเปก</p></article><article class="card"><h3>03. Prototype & QC</h3><p class="muted">ประสานทำตัวอย่าง ทดสอบ และตรวจคุณภาพกับพันธมิตร</p></article></div></section>
<section id="inquiry" style="background:var(--pale)"><div class="wrap layout"><div><div class="eyebrow">CUSTOM MEDIA INQUIRY</div><h2>แจ้งความต้องการวัสดุกรอง</h2><p class="muted">ส่งข้อมูลเพื่อให้ทีมงานนำไปประเมินแนวทางวัสดุที่เหมาะสม</p><p class="muted">ข้อมูลในแบบฟอร์มจะถูกบันทึกลงฐานข้อมูลของโปรเจกต์นี้เมื่อระบบเชื่อมต่อ MySQL สำเร็จ</p></div>
<form method="post" action="index.php#inquiry"><div class="fields">
<div class="field"><label for="company">บริษัท / หน่วยงาน</label><input id="company" name="company" maxlength="160"></div>
<div class="field"><label for="contact_name">ชื่อผู้ติดต่อ *</label><input id="contact_name" name="contact_name" required maxlength="120"></div>
<div class="field"><label for="email">อีเมล *</label><input id="email" name="email" type="email" required maxlength="190"></div>
<div class="field"><label for="phone">เบอร์โทรศัพท์</label><input id="phone" name="phone" maxlength="50"></div>
<div class="field"><label for="filter_type">ประเภทงานกรอง</label><select id="filter_type" name="filter_type"><option value="air">อากาศ / ฝุ่น</option><option value="liquid">น้ำ / ของเหลว</option><option value="custom">งานเฉพาะทาง</option></select></div>
<div class="field"><label for="reuse_need">การใช้งาน</label><select id="reuse_need" name="reuse_need"><option value="single">ใช้ครั้งเดียว</option><option value="reusable">ใช้ซ้ำ / ล้างได้</option><option value="unsure">ยังไม่แน่ใจ</option></select></div>
<div class="field"><label for="temperature">อุณหภูมิใช้งาน</label><select id="temperature" name="temperature"><option value="normal">ทั่วไป</option><option value="hot">อุณหภูมิสูง</option><option value="unknown">ยังไม่ทราบ</option></select></div>
<div class="field"><label for="chemical_exposure">สัมผัสสารเคมี</label><select id="chemical_exposure" name="chemical_exposure"><option value="unknown">ยังไม่ทราบ</option><option value="no">ไม่ใช่</option><option value="yes">ใช่</option></select></div>
<div class="field full"><label for="target_description">สิ่งที่ต้องการกรอง / รายละเอียด</label><textarea id="target_description" name="target_description" maxlength="5000"></textarea></div>
<div class="field full"><button class="btn" type="submit">ส่ง Requirement</button></div>
</div>
<?php if ($success): ?><div class="notice" role="status">ส่งข้อมูลสำเร็จแล้ว (บันทึกลงฐานข้อมูล) ทีมงานสามารถตรวจสอบคำขอได้ในหน้าผู้ดูแล</div><?php endif; ?>
<?php if ($error !== ''): ?><div class="notice err" role="alert"><?= e($error) ?></div><?php endif; ?>
</form></div></section>
</main><footer class="footer"><div class="wrap">FILTRATEX · Technical Filter Media · เว็บไซต์ต้นแบบสำหรับการศึกษา</div></footer>
</body></html>
