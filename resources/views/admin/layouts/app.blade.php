<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.3/font/bootstrap-icons.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="//cdn.datatables.net/2.1.8/css/dataTables.dataTables.min.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('js/app.js') }}">
    @yield('header')
    @yield('style')
  </head>
  <body>
    <div class="d-flex">
        <!-- Sidebar -->
        @include('admin.partials.sidebar')

        <!-- Main Content -->
        <div class="content w-100" id="main-content">
            <!-- Navbar -->
            @include('admin.partials.navbar')

            <!-- Page Content -->
            @yield('content')
        </div>
    </div>
    @if (session('success'))
        <script>
            toastr.success('{{ session('success') }}');
        </script>
    @endif

    @if (session('error'))
        <script>
            toastr.error('{{ session('error') }}');
        </script>
    @endif

    @if (session('info'))
        <script>
            toastr.info('{{ session('info') }}');
        </script>
    @endif

    @if (session('warning'))
        <script>
            toastr.warning('{{ session('warning') }}');
        </script>
    @endif

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="//cdn.ckeditor.com/4.21.0/full/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('parameter');
        CKEDITOR.replace('description');
        CKEDITOR.replace('outstanding');
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="//cdn.datatables.net/2.1.8/js/dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#myTable').DataTable({
              "stateSave": true, // Kích hoạt lưu trạng thái
                "pageLength": 5, // Số lượng mặc định mỗi trang là 5
                "lengthMenu": [ [5, 10, 20, 50], [5, 10, 20, 50] ],
                "language": {
                    "lengthMenu": "Hiển thị _MENU_ mục mỗi trang", // Thay đổi tiêu đề "Entries per page"
                    "search": "Tìm kiếm:", // Tùy chỉnh "Search"
                    "searchPlaceholder": "Tìm kiếm danh mục...", // Tùy chỉnh văn bản placeholder trong ô tìm kiếm
                    "zeroRecords": "Không tìm thấy kết quả",
                    // "info": "Hiển thị _START_ đến _END_ trong tổng số _TOTAL_ mục",
                }
            });
        });
    </script>
    <script>
      const toggleSidebar = () => {
        const sidebar = document.getElementById("sidebar");
        const content = document.getElementById("main-content");
        const icon = document.getElementById("toggle-icon");
        sidebar.classList.toggle("collapsed");
        content.classList.toggle("collapsed");
      };
    </script>
  </body>
</html>
