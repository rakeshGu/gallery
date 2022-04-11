<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" >
    <link href="{{asset('css/custom.css')}}" rel="stylesheet" >
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid"> 
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item">
            <a class="nav-link" aria-current="page" href="{{route('images.view')}}"> View Images</a>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="{{route('images.add')}}">Add Image</a>
            </li> 
        </ul>
        </div>
    </div>
    </nav>
    @yield('content')
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" ></script>
    <script src="https://code.jquery.com/jquery-3.6.0.js" ></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
    <script>
    $(document).ready(function () {
        $('#addMediaForm').validate({ // initialize the plugin
            rules: {
                user_name: {
                   required: true
                },
                image: {
                   required: true,
                    //max:500,
                   extension: "jpg|jpeg|png"
                }
            },
            messages: {
                user_name: {
                    required: "Please enter user name."
                },
                image: {
                    required: "Please upload file.",
                    extension: "Please upload file in these format only (jpg, jpeg, png).",
                   // max : "Maximum file size to upload is 500 kb."

                }
            }
        });
    });
    </script>
</body>
</html>