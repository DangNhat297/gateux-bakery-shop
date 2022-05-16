# DuAn1
- Cấu hình thông tin DB trong file lib/DB.php

- Cấu hình lại email trong file api/auth.php dòng 140 & 141, 198 & 199

- Cấu hình lại đường dẫn xampp: BASE_URL trong file config.php

- Cấu hình lại key reCaptcha trong file config.php

-- TK admin test: admin-123456789

# lib/Functions.php
- checkLength($name, $min, $max): kiểm tra độ dài $min - $max của $name, trả về true/false

- checkExtension($filename, $extension): kiểm tra định dạng của $filename với 
các giá trị mảng $extension, trả về true/false

- checkFileSize($filesize, $min, $max): kiểm tra kích thước của $filesize từ $min tới $max, trả
về giá trị true/false

- randomStr($num): trả về các kí tự ngẫu nhiên gồm chữ và số, độ dài $num

- product_price($priceFloat): trả về định dạng tiền VNĐ (100000 -> 100.000đ)

- slug($str): tạo slug cho giá trị truyền vào (nguyen van a -> nguyen-van-a)

- handleField($value): xử lý giá trị của các thẻ input trước khi thêm vào database, loại bỏ các khoảng trắng dư thừa và bỏ các thẻ html

- issetWishlist($id): kiểm tra sản phẩm $id đã có trong wishlist hay chưa, nếu có true/false

- showTime($time): giá trị truyền vào dạng datetime(Y-m-d H:i:s) -> hiển thị thời gian giống như fb (Just now, 2 minutes ago, 2 hours ago,...)
# lib/DB.php (chứa các hàm thực hiện câu query)
- fetchAll($sql): trả về nhiều bản ghi

- fetch($sql): trả về một bản ghi

- rowCount($sql): đếm số lượng bản ghi

- execute($sql): thực hiện câu query

- issetRecord($sql): kiểm tra sự tồn tại của bản ghi, trả về true nếu >= 1 bản ghi, ngược lại false

- getSettings(): trả về thông tin cấu hình website

-- $sql: là các câu lệnh query
-- cách thực hiện: 
    + khởi tạo đối tượng: DB::init()
    + chọn phương thức, ví dụ: DB::fetchAll("SELECT * FROM users")
    + chỉ cần tạo đối tượng 1 lần, vì đối tượng đã tạo trong file config nên chỉ việc sử dụng các phương thức

# lib/Session.php (các hàm dùng hỗ trợ dùng nhanh Session)
- init(): khởi tạo session <=> session_start()

- set($key,$val): gán giá trị cho session

- get($key) lấy giá trị session

- issetSession($key): kiểm tra sự tồn tại của session, trả về true/false

- checkSessionClient(): kiểm tra session người dùng

- checkSessionAdmin(): kiểm tra session admin hoặc nhân viên

- updateUser(): cập nhật session

- destroy(): hủy tất cả session

- unset($key): xóa session

-- Cách sử dụng tương tự như DB.php
    + Session::init()
    + VD: Session::get('user')


# lib/layout.php
get_header($path): Gắn Header cho các File cùng cấp với file Index.php

get_footer($path):Gắn Footer cho các File cùng cấp với file Index.php

get_nav($path): Gắn thanh Navigation cho các File cùng cấp với file Index.php

-- $path: đường dẫn truyền vào, mặc định là "./"