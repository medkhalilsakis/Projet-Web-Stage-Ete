<template>
  <div>
    <div class="carousel slide carousel-fade carousel-fullscreen" id="featured" data-ride="carousel">
      <ul class="carousel-indicators">
        <li data-target="#featured" data-slide-to="0" class="active"></li>
        <li data-target="#featured" data-slide-to="1"></li>
        <li data-target="#featured" data-slide-to="2"></li>
      </ul>

      <div class="carousel-inner">
        <div class="carousel-item active slide-1">
          <div class="overlay"></div>
          <div class="carousel-caption">
            <h1>Welcome to Wanderwise, <h6>Your Gateway to Unforgettable Travels!</h6></h1>
            <p class="lead pt-3">Curated stays, seamless booking, travel smarter & explore wider with Wanderwise.</p>
          </div>
        </div>

        <div class="carousel-item slide-2">
          <div class="overlay"></div>
          <div class="carousel-caption">
            <h1>Enjoy Luxury Experience</h1>
            <p class="lead pt-3">Discover a world of opulence and personalized service.</p>
          </div>
        </div>

        <div class="carousel-item slide-3">
          <div class="overlay"></div>
          <div class="carousel-caption">
            <h1>A Place to Stay and Relax</h1>
            <p class="lead pt-3">Unwind and recharge at your perfect escape.</p>
          </div>
        </div>
      </div>
      
      <a class="carousel-control-prev" href="#featured" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
      </a>

      <a class="carousel-control-next" href="#featured" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
      </a>
    </div>

    <div class="container">
      <div class="row py-5">
        <div class="col-md-12">
          <h2>Offers</h2>
          <p class="lead">Various deals, discounts, and special packages available..</p>
        </div>
        <div class="row">
          <div class="col-md-12 d-flex flex-column align-items-stretch">
            <div
              v-if="latestOffer"
              class="card bg-image hover-zoom"
              :style="{ backgroundImage: `url(${latestOfferImage})` }"
            >
              <div class="card-body text-white py-4">
                <h5 class="card-title">{{ latestOffer.titre }}</h5>
                <p class="card-text">{{ latestOffer.description }}</p>
                <router-link to="/login" class="btn btn-primary">Learn more</router-link>
              </div>
            </div>
            <div v-else>
              Loading...
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="container">
      <div class="row py-5">
        <div class="col-md-6 d-block-sm pb-4">
          <h2>About Us</h2>
          <p class="lead">At <u>Wanderwise</u>, we believe that travel is more than just a vacation; it's an opportunity to explore, discover, and create lasting memories. We are passionate about making travel accessible and hassle-free for everyone.</p>
          <div>
            <router-link to="/about" class="btn btn-primary text-uppercase pb-2 active" role="button" aria-pressed="true">Read more</router-link>
          </div>
        </div>
        <div class="col-md-6 d-block-sm">
          <img class="w-100" src="../assets/images/hotel-lobby.jpg" alt="Hotel lobby">
        </div>
      </div>
    </div>

  <div class="container">
    <div class="row">
      <h2 class="col-sm-12 text-center py-5">Destinations</h2>
      <div class="col-md-4 mb-3">
        <router-link>
          <div class="card bg-image hover-zoom" style="background-image: url('https://i.imgur.com/tqfpf5p.jpeg'); background-size: cover; background-position: center;">
            <div class="card-body text-white text-center d-flex flex-column align-items-center" style="background-color: rgba(0, 0, 0, 0.5);">
              <h2 class="card-title">France</h2>
              <p class="card-text">Explore the City of Lights</p>
            </div>
          </div>
        </router-link>
      </div>

    <div class="col-md-4 mb-3">
      <a href="">
        <div class="card bg-image hover-zoom" style="background-image: url('https://i.imgur.com/Q1b0G4e.jpeg'); background-size: cover; background-position: center; border-radius: 10px;">
          <div class="card-body text-white text-center d-flex flex-column align-items-center" style="background-color: rgba(0, 0, 0, 0.5);">
            <h2 class="card-title">Italy</h2>
            <p class="card-text">Discover the Eternal City</p>
          </div>
        </div>
      </a>
    </div>

    <div class="col-md-4 mb-3">
      <a href="">
        <div class="card bg-image hover-zoom" style="background-image: url('https://i.imgur.com/ilOBjVK.jpeg'); background-size: cover; background-position: center; border-radius: 10px;">
          <div class="card-body text-white text-center d-flex flex-column align-items-center" style="background-color: rgba(0, 0, 0, 0.5);">
            <h2 class="card-title">London</h2>
            <p class="card-text">Explore the Vibrant City</p>
          </div>
        </div>
      </a>
    </div>

    <div class="col-md-4 mb-3">
      <a href="">
        <div class="card bg-image hover-zoom" style="background-image: url('https://i.imgur.com/haFCXdz.jpeg'); background-size: cover; background-position: center; border-radius: 10px;">
          <div class="card-body text-white text-center d-flex flex-column align-items-center" style="background-color: rgba(0, 0, 0, 0.5);">
            <h2 class="card-title">Tunisia</h2>
            <p class="card-text">Discover the Land of Beauty</p>
          </div>
        </div>
      </a>
    </div>

    <div class="col-md-4 mb-3">
      <a href="">
        <div class="card bg-image hover-zoom" style="background-image: url('https://i.imgur.com/SMp24V4.jpeg'); background-size: cover; background-position: center; border-radius: 10px;">
          <div class="card-body text-white text-center d-flex flex-column align-items-center" style="background-color: rgba(0, 0, 0, 0.5);">
            <h2 class="card-title">Egypt</h2>
            <p class="card-text">Explore the Land of Pharaohs</p>
          </div>
        </div>
      </a>
    </div>
    <div class="col-md-4 mb-3">
      <a href="">
        <div class="card bg-image hover-zoom" style="background-image: url('https://i.imgur.com/iO2fb3P.jpeg'); background-size: cover; background-position: center;">
          <div class="card-body text-white text-center d-flex flex-column align-items-center" style="background-color: rgba(0, 0, 0, 0.5);">
            <h2 class="card-title">Spain</h2>  <p class="card-text">Explore the Passionate Capital</p>  </div>
        </div>
      </a>
    </div>
  </div>
  </div>



<div class="container">
    <div class="row">
      <h2 class="col-sm-12 text-center py-5">Blog</h2>
      <div v-for="(blog, index) in blogs" :key="index" class="col-md-4">
        <section class="mb-5">
          <img class="img-fluid" :src="blog.image" :alt="blog.titre">
          <h5 class="blog-title py-2">{{ blog.titre }}</h5>
          <p class="py-2">{{ getFirst10Words(blog.description) }}</p>
          <div>
            <router-link :to="`/blog/${blog.id}`" class="btn btn-primary text-uppercase pb-2 active">Read more</router-link>
          </div>
        </section>
      </div>
    </div>

    <div class="modal fade" id="servicesmodal">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-body">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
            <h2 class="modal-title text-center pb-4">Book Now</h2>
            <form>
              <fieldset class="form-group">
                <div class="form-group form-row">
                  <div class="form-group col">
                    <label class="col-form-label" for="check-in">Check In</label>
                    <input class="form-control" type="date" id="check-in" value="2019-08-18">
                  </div>
                  <div class="form-group col">
                    <label class="col-form-label" for="check-out">Check Out</label>
                    <input class="form-control" type="date" id="check-out" value="2019-08-19">
                  </div>
                </div>
                <div class="form-group form-row">
                  <div class="form-group col">
                    <label class="col-form-label" for="adult">Adults</label>
                    <input class="form-control" type="number" id="adult" value="2">
                  </div>
                  <div class="form-group col">
                    <label class="col-form-label" for="children">Children</label>
                    <input class="form-control" type="number" id="children" value="0">
                  </div>
                </div>
                <div class="form-group form-row">
                  <label class="col-form-label" for="room-type">Room Type</label>
                  <select class="form-control" id="room-type">
                    <option>Signature</option>
                    <option>Luxury</option>
                    <option>Deluxe</option>
                  </select>
                </div>
                <div class="form-group form-row">
                  <div class="form-group col">
                    <label class="col-form-label" for="fname">First Name</label>
                    <input class="form-control" type="text" id="fname">
                  </div>
                  <div class="form-group col">
                    <label class="col-form-label" for="lname">Last Name</label>
                    <input class="form-control" type="text" id="lname">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-form-label" for="email">Email</label>
                  <input class="form-control" type="email" id="email">
                </div>
                <div class="form-group">
                  <label class="col-form-label" for="phone">Phone Number</label>
                  <input class="form-control" type="tel" id="phone">
                </div>
                <div class="form-group">
                  <label class="col-form-label" for="special-request">Special Requests</label>
                  <textarea class="form-control" id="special-request" rows="3"></textarea>
                </div>
                <div class="form-group row">
                  <div class="form-check col">
                    <label class="form-check-label">
                      <input type="checkbox" class="form-check-input">I have read and accept terms and conditions.
                    </label>
                  </div>
                  <div class="form-check col">
                    <router-link type="submit" class="btn btn-primary text-uppercase pb-2" to="/login">Book Now</router-link>
                  </div>
                </div>
              </fieldset>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  </div>
</template>

<script>
export default {
  data() {
    return {
      blogs: [],
      latestOffer: null,
      latestOfferImage: 'https://wallpapers.com/images/hd/hi-res-beach-989kln7bmtjqupt1.jpg' 
    };
  },
  async created() {
    this.fetchBlogs();
    try {
      const response = await fetch('http://127.0.0.1:8000/api/offres');
      const offers = await response.json();
      this.latestOffer = offers[0];
    } catch (error) {
      console.error('Failed to fetch the latest offer:', error);
    }
  },
  methods: {
    async fetchBlogs() {
      try {
        const response = await fetch('http://127.0.0.1:8000/api/blogsalea');
        this.blogs = await response.json();
      } catch (error) {
        console.error('Error fetching blogs:', error);
      }
    },
    getFirst10Words(description) {
      return description.split(' ').slice(0, 10).join(' ') + (description.split(' ').length > 10 ? '...' : '');
    }
  }
};
</script>

<style scoped>
div a{
  text-decoration: none;
}
</style>
