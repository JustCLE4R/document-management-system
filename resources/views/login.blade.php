<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    
    <title>Masuk | {{ env('APP_NAME', 'DMS - UINSU') }}</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  </head>
<body>
  <div class="container">
    <div class="cover">
      <div class="front">
        <img src="/img/bg/akreditasi.svg" alt="">
        
        <div class="text" data-aos="fade-up" data-aos-duration="800">
          <div class="carousel">
            <span class="text-1">Selamat Datang <br> Di Website AIPT UIN Sumatera Utara</span>
            <span class="text-1" style="display: none;">Terima Kasih <br> Telah Menggunakan Layanan Kami</span>
            <!-- Add additional text items here -->
          </div>
          <div class="controls">
            <i class="fas fa-chevron-left prev"></i>
            <i class="fas fa-chevron-right next"></i>
          </div>
        </div>
        
        
      </div>      
    </div>
    <div class="forms">
        <div class="form-content">
          <div class="login-form">
              <div class="row justify-content-between" data-aos="fade-up" data-aos-duration="800">
                <div class="col-2">
                  <div class="title">Login </div>
                </div>
                <div class="col-3">
                  <span><img src="https://newuinsu.uinsu.ac.id/wp-content/uploads/2024/02/uin-dan-blu-png-2.png"  alt=""></span>
                </div>
              </div>
            @if (session()->has('error'))
            <div style="color: red; font-weight: bold;" role="alert" data-aos="fade-up" data-aos-duration="1000">
              {{ session()->get('error') }}
            </div>
            @endif
            <form action="/login" method="post">
              @csrf
              <div class="input-boxes">
                <div class="input-box" data-aos="fade-up" data-aos-duration="1200">
                  <i class="fas fa-envelope"></i>
                  <input type="text" name="username" placeholder="Masukan Username" oninput="validateNumericInput(this)" value="{{ $errors->has('username') ? '' : old('username') }}" maxlength="24" required>
                </div>
                @error('username')
                <div class="error error-txt">{{ $message }}</div>
                @enderror
                <div class="input-box" data-aos="fade-up" data-aos-duration="1400">
                  <i class="fas fa-lock"></i>
                  <input type="password" name="password" placeholder="Masukan Password" required>

                </div>
                @error('password')
                  <div class="error error-txt">{{ $message }}</div>
                @enderror
                <div class="button input-box" data-aos="fade-up" data-aos-duration="1600">
                  <input type="submit" value="Login">
                </div>                
              </div>
            </form>
          </div>
        </div>
    </div>
  </div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
  <script>
    $(document).ready(function() {
      AOS.init();
    });
    
    $(document).ready(function() {
      var currentIndex = 0;
      var texts = $(".carousel").children();

      function showText(index) {
        texts.hide();
        $(texts[index]).fadeIn();
      }

      function nextText() {
        currentIndex = (currentIndex + 1) % texts.length;
        showText(currentIndex);
      }

      function prevText() {
        currentIndex = (currentIndex - 1 + texts.length) % texts.length;
        showText(currentIndex);
      }

      $(".next").click(function() {
        nextText();
      });

      $(".prev").click(function() {
        prevText();
      });

      // Autoplay functionality
      setInterval(function() {
        nextText();
      }, 7000);

      // Show initial text
      showText(currentIndex);
    });


    </script>
</body>
</html>

