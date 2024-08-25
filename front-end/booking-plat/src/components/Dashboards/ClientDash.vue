<template>
  <div>
    <header class="navbar navbar-expand sticky-top bg-primary navbar-dark flex-column flex-md-row bd-navbar">
      <a class="navbar-brand mr-0 mr-md-2" href="#">WANDERWISE Studio</a>
      <div class="navbar-nav-scroll">
        <ul class="navbar-nav bd-navbar-nav flex-row">
          <li class="nav-item px-2">
            <a class="nav-link active" href="#">Home</a>
          </li>
          <li class="nav-item px-2">
            <a class="nav-link" href="#">Documentation</a>
          </li>
        </ul>
      </div>
      <ul class="navbar-nav flex-row ml-md-auto d-none d-md-flex">
        <li class="nav-item dropdown">
          <a class="nav-item nav-link dropdown-toggle mr-md-2" href="#" id="bd-versions" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <img class="rounded img123" :src="userAvatar" alt="User Avatar"> {{ userName }}
          </a>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="bd-versions">
            <a class="dropdown-item" href="#">
              <i class="fa fa-user-o pr-2"></i> Profile
            </a>
            <a class="dropdown-item" href="#">
              <i class="fa fa-cog pr-2"></i> Settings
            </a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#" @click="logout">
              <i class="fa fa-power-off pr-2"></i> Logout
            </a>
          </div>
        </li>
      </ul>
    </header>
    <div class="container-fluid">
      <div class="row">
        <aside class="col-md-2 d-none d-md-block bg-light sidebar">
          <div class="sidebar-sticky">
            <ul class="nav flex-column">
              <li class="nav-item">
                <a class="nav-link active" href="#" @click="changeTab('dashboard')">
                  <i class="fa fa-tachometer"></i>
                  Dashboard
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#" @click="changeTab('heb')">
                  <i class="fa fa-desktop"></i> Hébérgements
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#" @click="changeTab('res')">
                  <i class="fa fa-pencil-square-o"></i> Vos Réservations
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#" @click="changeTab('pay')">
                  <i class="fa fa-table"></i> Contact
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#" @click="changeTab('par')">
                  <i class="fa fa-table"></i> Paramétres
                </a>
              </li>
            </ul>
          </div>
        </aside>
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
          <component :is="currentTabComponent"></component>
        </main>
      </div>
    </div>
  </div>
</template>

<script>
import HebergList from './Client/HebergList.vue';
import MainDash from './Client/MainDash.vue';
import ReservationList from './Client/ReservationList.vue';
import ContactForm from './Client/ContactForm.vue';
import ParametresPage from './Client/ParametresPage.vue';

export default {
  components: {
    MainDash,
    HebergList,
    ReservationList,
    ContactForm,
    ParametresPage,
  },
  data() {
    return {
      currentTab: 'dashboard',
      user: JSON.parse(localStorage.getItem('user')),
      userName: '',
      userEmail: '',
      userAvatar: ''
    };
  },
  computed: {
    currentTabComponent() {
      switch (this.currentTab) {
        case 'dashboard':
          return 'MainDash';
        case 'heb':
          return 'HebergList';
        case 'res':
          return 'ReservationList';
        case 'pay':
          return 'ContactForm';
        case 'par':
          return 'ParametresPage';
        default:
          return 'div';
      }
    }
  },
  created() {
    const user = JSON.parse(localStorage.getItem('user'));
    if (user) {
      this.userName = `${user.nom} ${user.prenom}`;
      this.userEmail = user.email;
      this.userAvatar = user.genre === 'H' ? 'https://i.imgur.com/uoEVFOO.png' : 'https://i.imgur.com/rY9l5m5.png';
    }
  },
  methods: {
    changeTab(tab) {
      this.currentTab = tab;
    },
    logout() {
      localStorage.clear();
      this.$router.push('/');
    }
  }
};
</script>

<style scoped>

body {
  font-size: 0.875rem;
}

main {
  padding: 20px;
}

.sidebar-sticky {
  position: -webkit-sticky;
  position: sticky;
  top: 0;
  height: calc(100vh - 48px);
  padding-top: 0.5rem;
  overflow-x: hidden;
  overflow-y: auto;
}

.sidebar .nav-link {
  font-weight: 500;
  color: #333;
}

.sidebar .nav-link .fa {
  margin-right: 4px;
}

.sidebar .nav-link.active {
  color: #007bff;
}

.sidebar .sidebar-heading {
  font-size: 1.5rem;
}

.navbar-brand {
  padding-top: 0.75rem;
  padding-bottom: 0.75rem;
  font-size: 1rem;
  background-color: rgba(0, 0, 0, 0.25);
}

.navbar-nav .nav-link {
  padding-right: 0.25rem;
  padding-left: 0.25rem;
}

.user-info h3 {
  margin-top: 0;
}

.img123 {
  width: 30px;
}

.navbar-brand {
  font-family: 'Tilt Warp', sans-serif;
  font-size: 30px;
  letter-spacing: 2px;
  background: linear-gradient(to right, lightblue, lightyellow);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
}
</style>
