<template>
  <div>
    <header class="masthead blog-article-masthead mb-5">
      <div class="container h-100">
        <div class="row h-100 align-items-center">
          <div class="col-12 text-center">
            <h1 class="font-weight-light text-light">Blog Article</h1>
            <p class="lead text-light">See our latest news</p>
          </div>
        </div>
      </div>
    </header>

    <div class="container">
      <div class="row">
        <div class="col-md-8 py-5" v-if="blog">
          <article>
            <h3 class="blog-title pt-2 pb-0">{{ blog.titre }}</h3>
            <p>{{ formattedDate }}</p>
            <div class="row">
              <div v-for="(image, index) in images" :key="index" class="col-md-6 mb-4">
                <img class="img-fluid" :src="image" :alt="'Blog image ' + (index + 1)">
              </div>
            </div>
            
            <p v-html="cleanedDescription"></p>


            <div class="d-flex justify-content-between pt-4">
              <router-link :to="`/blog/${blogId - 1}`" class="btn btn-primary" v-if="blogId > 1">Prev</router-link>
              <router-link to="/blog" class="btn btn-primary">Main Page</router-link>
              <router-link :to="`/blog/${blogId + 1}`" class="btn btn-primary" v-if="blogId < maxBlogId">Next</router-link>
            </div>
          </article>
        </div>

        <aside class="col-md-4 pt-sm-0 pt-md-5">
          <section>
            <h3>Categories</h3>
            <ul class="pl-3">
              <li class="pb-2"><a class="text-dark" href="#">Travel</a></li>
              <li class="pb-2"><a class="text-dark" href="#">Destination</a></li>
              <li class="pb-2"><a class="text-dark" href="#">Vacation</a></li>
              <li class="pb-2"><a class="text-dark" href="#">Hotel</a></li>
              <li class="pb-2"><a class="text-dark" href="#">Restaurant</a></li>
            </ul>

            <h3>Tags</h3>
            <button class="btn btn-primary m-1">news</button>
            <button class="btn btn-primary m-1">travel</button>
            <button class="btn btn-primary m-1">vacation</button>
            <button class="btn btn-primary m-1">reservation</button>
            <button class="btn btn-primary m-1">reviews</button>
            <button class="btn btn-primary m-1">booking</button>
          </section>
        </aside>
      </div>
    </div>

    <div class="modal fade" id="servicesmodal" ref="servicesmodal">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-body">
            <button type="button" class="close" @click="closeModal">
              <span aria-hidden="true">&times;</span>
            </button>
            <h2 class="modal-title text-center pb-4">Book Now</h2>
            <form @submit.prevent="submitBooking">
              <fieldset class="form-group">
                <div class="form-row">
                  <div class="col">
                    <label for="check-in">Check In</label>
                    <input type="date" class="form-control" id="check-in" v-model="booking.checkIn">
                  </div>
                  <div class="col">
                    <label for="check-out">Check Out</label>
                    <input type="date" class="form-control" id="check-out" v-model="booking.checkOut">
                  </div>
                </div>

                <div class="form-row">
                  <div class="col">
                    <label>Adults</label>
                    <select class="form-control" v-model="booking.adults">
                      <option>1</option>
                      <option>2</option>
                      <option>3</option>
                      <option>4</option>
                    </select>
                  </div>
                  <div class="col">
                    <label>Children</label>
                    <select class="form-control" v-model="booking.children">
                      <option>1</option>
                      <option>2</option>
                      <option>3</option>
                      <option>4</option>
                    </select>
                  </div>
                </div>

                <div class="form-group">
                  <label>Room</label>
                  <select class="form-control" v-model="booking.room">
                    <option>Luxury Suite</option>
                    <option>Signature Room</option>
                    <option>Classic Room</option>
                    <option>Deluxe Room</option>
                  </select>
                </div>

                <button type="submit" class="btn btn-primary">Submit</button>
              </fieldset>
            </form>
          </div>
        </div>
      </div>
    </div>

    <footer class="page-footer font-small text-center text-md-left">
          <div class="container py-5">
            <div class="row">
              <div class="col-md-4 mx-auto">
                <h3 class="font-weight-bold text-uppercase mt-3 mb-4">Address</h3>
  
              <div>
                <p>Main Street 123</p>
                <p>New York, NY, USA</p>
              </div>
  
            </div> 
            <hr class="clearfix w-100 d-md-none">
  
            <div class="col-md-4 mx-auto">
  
              <h3 class="font-weight-bold text-uppercase mt-3 mb-4">Reservation</h3>
  
              <div>
                <p>Phone: 111-234-5678</p>
                <p>Email: contact@wanderwise.com</p>
                <div>
                  <router-link to="/login" type="button" class="btn btn-primary pb-2 text-uppercase" data-toggle="modal"
                    data-target="#servicesmodal">Book Now</router-link>
                </div>
              </div>
  
            </div> 
            <hr class="clearfix w-100 d-md-none">
   
            <div class="col-md-4 mx-auto">
   
              <h3 class="font-weight-bold text-uppercase mt-3 mb-4">Newsletter</h3>
  
              <form class="justify-content-center mx-5 mx-md-0">
                <div class="form-group">
                  <label class="form-control-label sr-only" for="email">Email address</label>
                  <input class="form-control" type="email" id="email" aria-describedby="email"
                    placeholder="Your email">
                </div> 
  
                <div class="input-group-append">
                  <button class="btn btn-sm btn-outline-white my-0" type="button">Sign up</button>
                </div>
              </form>
  
              <div class="icons d-flex justify-content-between mx-5 mx-md-0">
                <a href="http://www.instagram.com"><i class="fab fa-instagram"></i></a>
                <a href="http://www.facebook.com"><i class="fab fa-facebook-square"></i></a>
                <a href="http://www.twitter.com"><i class="fab fa-twitter-square"></i></a>
                <a href="http://www.youtube.com"><i class="fab fa-youtube-square"></i></a>
              </div>
  
            </div>  
  
          </div> 
  
        </div> 
  
        <div class="footer-copyright text-center bg-dark text-light py-3">© 2024
          <a class="text-light" href=""> Wanderwise Studio</a>
        </div>
 
      </footer>
  </div>
</template>

<script>
export default {
  data() {
    return {
      blog: null,
      images: [],
      blogId: parseInt(this.$route.params.id),
      maxBlogId: 10, 
      booking: {
        checkIn: "",
        checkOut: "",
        adults: "1",
        children: "0",
        room: "Luxury Suite",
      },
    };
  },
  computed: {
    formattedDate() {
      if (this.blog && this.blog.date) {
        const date = new Date(this.blog.date);
        const day = String(date.getDate()).padStart(2, '0');
        const month = String(date.getMonth() + 1).padStart(2, '0');
        const year = date.getFullYear();
        return `${day}/${month}/${year}`;
      }
      return '';
    },
    cleanedDescription() {
        if (this.blog && this.blog.description) {
        return this.blog.description
          .replace(/<<([^>]+)>>/g, '<br><br><strong>$1</strong><br><br>') 
          .replace(/^\s+|\s+$/g, '')
          .replace(/\s{2,}/g, ' ');
      }
      return '';
    }
  },
  created() {
    this.fetchBlog();
  },
  methods: {
    async fetchBlog() {
      try {
        const response = await fetch(`http://127.0.0.1:8000/api/blogs/${this.blogId}`);
        const data = await response.json();
        this.blog = data;
        this.images = this.parseImages(data.image); 
      } catch (error) {
        console.error('Error fetching blog:', error);
      }
    },
    parseImages(imagesString) {
      return imagesString.split(' ').filter(url => url); 
    },
    openModal() {
      this.$refs.servicesmodal.style.display = "block";
      this.$refs.servicesmodal.classList.add("show");
    },
    closeModal() {
      this.$refs.servicesmodal.style.display = "none";
      this.$refs.servicesmodal.classList.remove("show");
    },
    submitBooking() {
      console.log('Booking submitted:', this.booking);
    },
  },
};
</script>

<style scoped>
</style>
