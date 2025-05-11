@extends('layouts.app')

@section('content')
<section id="contact" class="contact section">

      <!-- Section Title -->
      <div class="container section-title aos-init aos-animate" data-aos="fade-up" bis_skin_checked="1">
        <h2>Contact</h2>
        <p><span>Need Help?</span> <span class="description-title">Contact Us</span></p>
      </div><!-- End Section Title -->

      <div class="container aos-init aos-animate" data-aos="fade-up" data-aos-delay="100" bis_skin_checked="1">

        <div class="mb-5" bis_skin_checked="1">
          <iframe style="width: 100%; height: 400px;" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d904.2218716928458!2d110.86616980043193!3d-6.7849215130664104!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e70dad011b861e1%3A0xded15e85b4e6c83c!2sFakultas%20Teknik%20-%20UMK!5e0!3m2!1sid!2sid!4v1746730359492!5m2!1sid!2sid" frameborder="0" allowfullscreen=""></iframe>
            
        </div><!-- End Google Maps -->

        <div class="row gy-4" bis_skin_checked="1">

          <div class="col-md-6" bis_skin_checked="1">
            <div class="info-item d-flex align-items-center aos-init aos-animate" data-aos="fade-up" data-aos-delay="200" bis_skin_checked="1">
              <i class="icon bi bi-geo-alt flex-shrink-0"></i>
              <div bis_skin_checked="1">
                <h3>Alamat</h3>
                <p>A108 Adam Street, New York, NY 535022</p>
              </div>
            </div>
          </div><!-- End Info Item -->

          <div class="col-md-6" bis_skin_checked="1">
            <div class="info-item d-flex align-items-center aos-init aos-animate" data-aos="fade-up" data-aos-delay="300" bis_skin_checked="1">
              <i class="icon bi bi-telephone flex-shrink-0"></i>
              <div bis_skin_checked="1">
                <h3>Call Us</h3>
                <p>087732168347</p>
              </div>
            </div>
          </div><!-- End Info Item -->

          <div class="col-md-6" bis_skin_checked="1">
            <div class="info-item d-flex align-items-center aos-init aos-animate" data-aos="fade-up" data-aos-delay="400" bis_skin_checked="1">
              <i class="icon bi bi-envelope flex-shrink-0"></i>
              <div bis_skin_checked="1">
                <h3>Email Us</h3>
                <p>202351125@std.umk.ac.id</p>
              </div>
            </div>
          </div><!-- End Info Item -->

          <div class="col-md-6" bis_skin_checked="1">
            <div class="info-item d-flex align-items-center aos-init aos-animate" data-aos="fade-up" data-aos-delay="500" bis_skin_checked="1">
              <i class="icon bi bi-clock flex-shrink-0"></i>
              <div bis_skin_checked="1">
                <h3>Opening Hours<br></h3>
                <p><strong>Mon-Sat:</strong> 11AM - 23PM; <strong>Sunday:</strong> Closed</p>
              </div>
            </div>
          </div><!-- End Info Item -->

        </div>

        <form class="php-email-form aos-init" data-aos="fade-up" data-aos-delay="600" onsubmit="sendToWhatsApp(event)">
          <div class="row gy-4" bis_skin_checked="1">

            <div class="col-md-6" bis_skin_checked="1">
              <input type="text" id="name" name="name" class="form-control" placeholder="Your Name" required="">
            </div>

            <div class="col-md-6 " bis_skin_checked="1">
              <input type="email" id="email" class="form-control" name="email" placeholder="Your Email" required="">
            </div>

            <div class="col-md-12" bis_skin_checked="1">
              <input type="text" id="subject" class="form-control" name="subject" placeholder="Subject" required="">
            </div>

            <div class="col-md-12" bis_skin_checked="1">
              <textarea class="form-control" id="message" name="message" rows="6" placeholder="Message" required=""></textarea>
            </div>

            <div class="col-md-12 text-center" bis_skin_checked="1">
              <div class="loading" bis_skin_checked="1">Loading</div>
              <div class="error-message" bis_skin_checked="1"></div>
              <div class="sent-message" bis_skin_checked="1">Your message has been sent. Thank you!</div>

              <button type="submit">Send Message</button>
            </div>

          </div>
        </form><!-- End Contact Form -->

        <script>
          function sendToWhatsApp(event) {
            event.preventDefault();
            const name = document.getElementById('name').value;
            const email = dsocument.getElementById('email').value;
            const subject = document.getElementById('subject').value;
            const message = document.getElementById('message').value;

            const whatsappNumber = "087732168347";
            const whatsappURL = `https://wa.me/${whatsappNumber}?text=${encodeURIComponent(
              `Name: ${name}\nEmail: ${email}\nSubject: ${subject}\nMessage: ${message}`
            )}`;

            window.open(whatsappURL, '_blank');
          }
        </script>

      </div>

    </section>
@endsection