import toastr from 'toastr';
import 'toastr/build/toastr.min.css';
toastr.options = {
    "positionClass": "toast-top-right",  // Đặt vị trí góc trên bên phải
    "closeButton": true, // Thêm nút đóng
    "progressBar": true, // Hiển thị thanh tiến trình
    "timeOut": "5000", // Thời gian hiển thị là 5 giây
    "extendedTimeOut": "1000", // Thời gian gia hạn khi hover vào thông báo
};
window.toastr = toastr;