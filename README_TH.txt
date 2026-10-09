FILTRATEX — PHP + MySQL starter project
=======================================

สิ่งที่มีในโปรเจกต์
- หน้าเว็บไซต์ index.php
- แบบฟอร์มส่ง Requirement บันทึกลง MySQL จริง
- หน้า admin/login.php สำหรับผู้ดูแล
- หน้า admin/inquiries.php ดูรายการคำขอ
- schema.sql สำหรับสร้างฐานข้อมูลและตาราง
- config/database.php สำหรับการเชื่อมต่อฐานข้อมูล

ข้อกำหนด
- ติดตั้ง XAMPP (Apache + PHP + MySQL/MariaDB)
- ใช้ VS Code แก้ไขโค้ดได้

วิธีติดตั้งบน Windows
1. ติดตั้งและเปิด XAMPP Control Panel
2. กด Start ที่ Apache และ MySQL
3. นำโฟลเดอร์ FILTRATEX_PHP_MySQL ไปไว้ใน C:\xampp\htdocs\
   ให้ได้ตำแหน่ง C:\xampp\htdocs\FILTRATEX_PHP_MySQL\
4. เปิด http://localhost/phpmyadmin
5. ไปที่แท็บ Import แล้วเลือกไฟล์ schema.sql จากโฟลเดอร์โปรเจกต์
   หรือเปิดแท็บ SQL แล้ววางเนื้อหาใน schema.sql
6. ตรวจสอบค่าการเชื่อมต่อใน config/database.php
   ค่าเริ่มต้น XAMPP มักใช้ user root และรหัสผ่านว่างในเครื่อง local
7. เปิด http://localhost/FILTRATEX_PHP_MySQL/
8. หน้าเข้าสู่ระบบผู้ดูแล:
   http://localhost/FILTRATEX_PHP_MySQL/admin/login.php

บัญชีผู้ดูแลเริ่มต้น (สำหรับทดสอบ local เท่านั้น)
- Username: admin
- Password: ChangeMe123!

สำคัญก่อนใช้งานจริง
- เปลี่ยนรหัสผ่านผู้ดูแลทันที
- อย่าเผยแพร่ไฟล์นี้ขึ้นอินเทอร์เน็ตโดยใช้บัญชีเริ่มต้น
- ตั้งรหัสผ่าน MySQL ที่แข็งแรง และใช้ HTTPS
- โปรเจกต์นี้เป็น starter สำหรับการเรียน/ต้นแบบ ไม่ใช่ระบบ production ที่ผ่านการตรวจสอบความปลอดภัย
