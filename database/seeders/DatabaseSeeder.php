<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            'ROLENAME' => 'Admin',
        ]);
        DB::table('roles')->insert([
            'ROLENAME' => 'User',
        ]);
        DB::table('roles')->insert([
            'ROLENAME' => 'Blogger',
        ]);
        DB::table('users')->insert([
            'username' => 'admin',
            'ROLE_ID' => 1,
            'password' => bcrypt('123456'),
            'fullname' => 'Thanh Br',
            'email' => 'admin@gmail.com',
            'IsDeleted' => 0,
            'CreatedBy' => 1,
            'CreatedDate' => now()
        ]);
        DB::table('users')->insert([
            'username' => 'thuuser',
            'ROLE_ID' => 2,
            'password' => bcrypt('123456'),
            'fullname' => 'Thư Hồ',
            'email' => 'thuuser@gmail.com',
            'IsDeleted' => 0,
            'CreatedBy' => 1,
            'CreatedDate' => now()
        ]);
        DB::table('users')->insert([
            'username' => 'nhiuser',
            'ROLE_ID' => 2,
            'password' => bcrypt('123456'),
            'fullname' => 'Nhi Nguyễn',
            'email' => 'nhiuser@gmail.com',
            'IsDeleted' => 0,
            'CreatedBy' => 1,
            'CreatedDate' => now()
        ]);
        DB::table('inventories')->insert([
            'INVID' => '100001',
            'INVNAME' => 'Kho ở thành phố Hồ Chí Minh',
            'CreatedBy' => 1,
            'CreatedDate' => now(),
        ]);
        DB::table('inventories')->insert([
            'INVID' => '100002',
            'INVNAME' => 'Kho ở Bình Dương',
            'CreatedBy' => 1,
            'CreatedDate' => now(),
        ]);
        DB::table('inventories')->insert([
            'INVID' => '100003',
            'INVNAME' => 'Kho ở Long An',
            'CreatedBy' => 1,
            'CreatedDate' => now(),
        ]);
        DB::table('brands')->insert([
            'BRANAME' => 'Dell',
            'BRAADDRESS' => 'Nhật',
            'BRAEMAIL' => 'dell@gmail.com',
            'BRAPHONE' => '111-222-333',
            'CreatedBy' => 1,
            'CreatedDate' => now(),
        ]);
        DB::table('brands')->insert([
            'BRANAME' => 'MAC',
            'BRAADDRESS' => 'Mỹ',
            'BRAEMAIL' => 'mac@gmail.com',
            'BRAPHONE' => '777-888-999',
            'CreatedBy' => 1,
            'CreatedDate' => now(),
        ]);
        DB::table('brands')->insert([
            'BRANAME' => 'Asus',
            'BRAADDRESS' => 'Trung Quốc',
            'BRAEMAIL' => 'asus@gmail.com',
            'BRAPHONE' => '555-666-777',
            'CreatedBy' => 1,
            'CreatedDate' => now(),
        ]);
        DB::table('products')->insert([
            'BRA_ID' => 1,
            'PRONAME' => 'Laptop Dell core 7',
            'PRODESCRIPTION' => 'Sản phẩm có giá tốt thích hợp cho nhiều người',
            'PROSTATUS' => 0,
            'PROMODEL' => 2021,
            'PROTYPE' => 1,
            'PROSIZE' => '25/30 cm',
            'PROWEIGHT' => 3,
            'CreatedBy' => 1,
            'CreatedDate' => now(),
        ]);
        DB::table('products')->insert([
            'BRA_ID' => 1,
            'PRONAME' => 'MacBook Pro',
            'PRODESCRIPTION' => 'Sản phẩm có giá tốt thích hợp cho nhiều người',
            'PROSTATUS' => 1,
            'PROMODEL' => 2021,
            'PROTYPE' => 0,
            'PROSIZE' => '27/29 cm',
            'PROWEIGHT' => 2,
            'CreatedBy' => 1,
            'CreatedDate' => now(),
        ]);
        DB::table('products')->insert([
            'BRA_ID' => 2,
            'PRONAME' => 'Laptop Asus core i5',
            'PRODESCRIPTION' => 'Sản phẩm có giá tốt thích hợp cho nhiều người',
            'PROSTATUS' => 1,
            'PROMODEL' => 2020,
            'PROTYPE' => 1,
            'PROSIZE' => '28/32 cm',
            'PROWEIGHT' => 4,
            'CreatedBy' => 1,
            'CreatedDate' => now(),
        ]);
        DB::table('customers')->insert([
            'CUSNAME' => 'Nguyễn Linh Nhi',
            'CUSPHONE' => '0934567899',
            'CUSADDRESS' => 'Số 23, Tô Ký, quận 12',
            'CUSEMAIL' => 'nhi@gmail.com',
            'CUSUSERNAME' => 'nhinguyen',
            'CUSPASSWORD' => bcrypt('123456'),
            'CUSTYPE' => 1,
            'CreatedBy' => 1,
            'CreatedDate' => now(),
        ]);
        DB::table('customers')->insert([
            'CUSNAME' => 'Trần Văn Nam',
            'CUSPHONE' => '0912345678',
            'CUSADDRESS' => 'Số 16, Quang Trung, quận Gò Vấp',
            'CUSEMAIL' => 'nam@gmail.com',
            'CUSUSERNAME' => 'namtran',
            'CUSPASSWORD' => bcrypt('123456'),
            'CUSTYPE' => 0,
            'CreatedBy' => 1,
            'CreatedDate' => now(),
        ]);
        DB::table('customers')->insert([
            'CUSNAME' => 'Lê Ánh Tuyết',
            'CUSPHONE' => '0914725836',
            'CUSADDRESS' => 'Số 78, Hồng Hà, quận Tân Bình',
            'CUSEMAIL' => 'tuyet@gmail.com',
            'CUSUSERNAME' => 'tuyetle',
            'CUSPASSWORD' => bcrypt('123456'),
            'CUSTYPE' => 0,
            'CreatedBy' => 1,
            'CreatedDate' => now(),
        ]);
        DB::table('comments')->insert([
            'CUS_ID' => 1,
            'PRO_ID' => 1,
            'COMTITLE' => 'Sản phẩm tiện lợi',
            'COMDESC' => 'Tôi thấy sản phẩm đáp ứng đầy đủ tính năng của tôi, giao hàng còn nhanh',
            'COMDATE' => now(),
            'CreatedBy' => 1,
            'CreatedDate' => now(),
        ]);
        DB::table('comments')->insert([
            'CUS_ID' => 2,
            'PRO_ID' => 2,
            'COMTITLE' => 'Sản phẩm tiện lợi',
            'COMDESC' => 'Tôi thấy sản phẩm đáp ứng đầy đủ tính năng của tôi, giao hàng còn nhanh',
            'COMDATE' => now(),
            'CreatedBy' => 1,
            'CreatedDate' => now(),
        ]);
        DB::table('comments')->insert([
            'CUS_ID' => 3,
            'PRO_ID' => 3,
            'COMTITLE' => 'Sản phẩm tiện lợi',
            'COMDESC' => 'Tôi thấy sản phẩm đáp ứng đầy đủ tính năng của tôi, giao hàng còn nhanh',
            'COMDATE' => now(),
            'CreatedBy' => 1,
            'CreatedDate' => now(),
        ]);
        DB::table('permissions')->insert([
            'PERNAME' => 'Xem trang chủ',
            'PERNOTE' => 'Có thể xem bảng thống kê của cửa hàng.',
            'CreatedBy' => 1,
            'CreatedDate' => now(),
        ]);
        DB::table('permissions')->insert([
            'PERNAME' => 'Quản lý kho',
            'PERNOTE' => 'Có thể xem, thêm, sửa, xóa kho.',
            'CreatedBy' => 1,
            'CreatedDate' => now(),
        ]);
        DB::table('permissions')->insert([
            'PERNAME' => 'Xem danh sách kho',
            'PERNOTE' => 'Chỉ có thể xem danh sách kho.',
            'CreatedBy' => 1,
            'CreatedDate' => now(),
        ]);
        DB::table('permissions')->insert([
            'PERNAME' => 'Quản lý hóa đơn',
            'PERNOTE' => 'Có thể xem, thêm, sửa, xóa hóa đơn.',
            'CreatedBy' => 1,
            'CreatedDate' => now(),
        ]);
        DB::table('permissions')->insert([
            'PERNAME' => 'Xem danh sách hóa đơn',
            'PERNOTE' => 'Chỉ có thể xem danh sách hóa đơn.',
            'CreatedBy' => 1,
            'CreatedDate' => now(),
        ]);
        DB::table('permissions')->insert([
            'PERNAME' => 'Quản lý sản phẩm',
            'PERNOTE' => 'Có thể xem, thêm, sửa, xóa sản phẩm.',
            'CreatedBy' => 1,
            'CreatedDate' => now(),
        ]);
        DB::table('permissions')->insert([
            'PERNAME' => 'Xem danh sách sản phẩm',
            'PERNOTE' => 'Chỉ có thể xem danh sách sản phẩm.',
            'CreatedBy' => 1,
            'CreatedDate' => now(),
        ]);
    }
}
