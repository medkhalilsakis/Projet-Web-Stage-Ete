<template>
  <div>
    <header class="masthead blog-masthead mb-5">
      <div class="container h-100">
        <div class="row h-100 align-items-center">
          <div class="col-12 text-center">
            <h1 class="font-weight-light text-light">Our Blog</h1>
            <p class="lead text-light">See our latest news</p>
          </div>
        </div>
      </div>
    </header>

    <div class="container">
      <div class="row">
        <div class="col-md-8 py-5">
          <div class="container">
            <div class="row">
            
              <div v-for="(article, index) in articles" :key="index" class="col-md-6">
                <section class="mb-5">
                 
                  <img class="img-fluid" :src="article.images[0]" :alt="article.title">
                  <h3 class="blog-title pt-2 pb-0">{{ article.title }}</h3>
                  <p>{{ article.date }}</p>
                  <p class="py-2">{{ truncateDescription(article.description) }}</p>
                  <div>
                    <router-link :to="article.link" class="btn btn-primary text-uppercase pb-2 active" role="button" aria-pressed="true">Read more</router-link>
                  </div>
                </section>
              </div>
            </div>
          
            <nav class="mt-2" aria-label="Page navigation">
              <ul class="pagination justify-content-center">
                <li class="page-item" :class="{ 'disabled': currentPage === 1 }"><a class="page-link" @click="setCurrentPage(currentPage - 1)" href="#">&lt;</a></li>
                <li v-for="page in totalPages" :key="page" class="page-item" :class="{ 'active': currentPage === page }">
                  <a class="page-link" @click="setCurrentPage(page)" href="#">{{ page }}</a>
                </li>
                <li class="page-item" :class="{ 'disabled': currentPage === totalPages }"><a class="page-link" @click="setCurrentPage(currentPage + 1)" href="#">&gt;</a></li>
              </ul>
            </nav>
           
          </div>
        </div>
   
        <div class="col-md-4 pt-sm-0 pt-md-5">
      <div class="container pb-5">
        <div class="row">
          <h3 class="col-sm-12 pb-2">Categories</h3>
          <div>
            <button v-for="(category, index) in randomCategories" :key="index" class="btn btn-primary m-1">{{ category }}</button>
          </div>

          <h3 class="col-sm-12 pb-2">Tags</h3>
          <div>
            <button v-for="(tag, index) in randomTags" :key="index" class="btn btn-primary m-1">{{ tag }}</button>
          </div>
        </div>
      </div>
    </div>
      
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
                    <input class="form-control" type="date" id="check-in" value="2019-08-19">
                  </div>
                  <div class="form-group col">
                    <label class="col-form-label" for="check-out">Check Out</label>
                    <input class="form-control" type="date" id="check-out" value="2019-08-20">
                  </div>
                </div>
                <div class="form-group form-row">
                  <div class="form-group col">
                    <label class="col-form-label">Adults</label>
                    <select class="form-control">
                      <option>1</option>
                      <option>2</option>
                      <option>3</option>
                      <option>4</option>
                    </select>
                  </div>
                  <div class="form-group col">
                    <label class="col-form-label">Children</label>
                    <select class="form-control">
                      <option>1</option>
                      <option>2</option>
                      <option>3</option>
                      <option>4</option>
                    </select>
                  </div>
                </div>
                <div class="form-group row w-100 mx-auto">
                  <label class="col-form-label">Room</label>
                  <select class="form-control">
                    <option>Luxury Suite</option>
                    <option>Signature Room</option>
                    <option>Classic Room</option>
                    <option>Deluxe Room</option>
                  </select>
                </div>
                <div class="form-group row pt-5">
                  <div class="col-auto">
                    <button class="btn btn-primary" type="submit">Submit</button>
                  </div>
                </div>
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
                <router-link type="button" class="btn btn-primary pb-2 text-uppercase" data-toggle="modal" data-target="#servicesmodal" to="/login">Book Now</router-link>
              </div>
            </div>
          </div>
          <hr class="clearfix w-100 d-md-none">
          <div class="col-md-4 mx-auto">
            <h3 class="font-weight-bold text-uppercase mt-3 mb-4">Newsletter</h3>
            <form class="justify-content-center mx-5 mx-md-0">
              <div class="form-group">
                <label class="form-control-label sr-only" for="email">Email address</label>
                <input class="form-control" type="email" id="email" aria-describedby="email" placeholder="Your email">
              </div>
              <div class="input-group-append">
                <button class="btn btn-sm btn-outline-white my-0" type="button">Sign up</button>
              </div>
            </form>
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
import axios from 'axios';

export default {
  data() {
    return {
      articles: [],        
      recentPosts: [],    
      categories: [],      
      tags: [],            
      latestPost: null,    
      randomCategories: [],
      randomTags: [],      
      currentPage: 1,     
      totalPages: 1,       
    };
  },
  mounted() {
    this.fetchArticles();
    this.fetchRecentPosts();
    this.fetchCategories();
    this.fetchTags();
  },
  methods: {
    fetchArticles() {
      axios.get('http://127.0.0.1:8000/api/blogs')
        .then(response => {
          this.articles = response.data.map(blog => ({
            title: blog.titre,
            images: blog.image.split(' '),  
            date: this.formatDate(blog.date),
            description: blog.description,
            link: `/blog/${blog.id}`, 
          }));

        
          if (this.articles.length > 0) {
            this.latestPost = this.articles[0];
          }
        })
        .catch(error => {
          console.error('Error fetching articles:', error);
        });
    },
    fetchRecentPosts() {
      axios.get('http://127.0.0.1:8000/api/recent-posts') 
        .then(response => {
          if (response.data.length > 0) {
            const post = response.data[0]; 
            this.latestPost = {
              title: post.title,
              images: post.image.split(' '), 
              link: `/blog/${post.id}`
            };
          }
        })
        .catch(error => {
          console.error('Error fetching recent posts:', error);
        });
    },
    fetchCategories() {
    axios.get('http://127.0.0.1:8000/api/blogscategories')
      .then(response => {
        
        this.categories = response.data.map(category => category); 
        this.randomCategories = this.getRandomItems(this.categories, 5); 
      })
      .catch(error => {
        console.error('Error fetching categories:', error);
      });
  },
  fetchTags() {
    axios.get('http://127.0.0.1:8000/api/blogstags')
      .then(response => {
        
        this.tags = response.data.map(tagGroup => tagGroup.split(', ')).flat(); 
        this.randomTags = this.getRandomItems(this.tags, 5);
      })
      .catch(error => {
        console.error('Error fetching tags:', error);
      });
  },
    formatDate(dateString) {
      const options = { year: 'numeric', month: 'long', day: 'numeric' };
      const date = new Date(dateString);
      return isNaN(date.getTime()) ? 'Invalid Date' : date.toLocaleDateString(undefined, options);
    },
    truncateDescription(description) {
      const maxLength = 200; 
      return description.length > maxLength ? description.substring(0, maxLength) + '.....' : description;
    },
    getRandomItems(array, count) {
      let shuffled = array.slice(0), i = array.length, min = i - count, temp, index;
      while (i-- > min) {
        index = Math.floor((i + 1) * Math.random());
        temp = shuffled[index];
        shuffled[index] = shuffled[i];
        shuffled[i] = temp;
      }
      return shuffled.slice(min);
    },
    setCurrentPage(page) {
      if (page > 0 && page <= this.totalPages) {
        this.currentPage = page;
        this.fetchArticles(); 
      }
    }
  }
};
</script>

<style scoped>
</style>
