<template>
  <div class="admin-dashboard">
    <header class="navbar navbar-expand sticky-top bg-primary navbar-dark flex-md-row bd-navbar">
  <div class="container-fluid">
    <div class="col-4 d-flex align-items-center">
      <a class="navbar-brand mr-0 mr-md-2" href="#">WANDERWISE Studio</a>
    </div>

    <div class="col-6 d-flex align-items-center justify-content-center">
      <form class="d-flex w-100" role="search">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-light" type="submit">Search</button>
      </form>
    </div>

    <div class="col-2 d-flex justify-content-end align-items-center">
      <ul class="navbar-nav flex-row">
        <li class="nav-item dropdown">
          <a class="nav-item nav-link dropdown-toggle mr-md-2" href="#" id="bd-versions" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <img class="rounded avatarimg" :src="profileImage" alt="User Avatar"> {{ userName }}
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
    </div>
  </div>
</header>


    <main class="container-fluid">
      <div class="row">
        <div class="col-lg-2 col-md-3 col-sm-4">
          <nav class="sidebar">
            <div class="position-sticky">
              <ul class="nav flex-column">
                <li class="nav-item">
                  <a class="nav-link active" href="#" @click="setCurrentTab('dashboard')">
                    <i class="bi bi-house-door"></i> Dashboard
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#" @click="setCurrentTab('heb')">
                    <i class="bi bi-people"></i> Hébergements
                  </a>
                  <ul>
                    <li><a class="nav-link" href="#" @click="setCurrentTab('ajoutheb')">Ajouter Hébergement</a></li>
                  </ul>
                </li>
                <li>
                  <a class="nav-link" href="#" @click="setCurrentTab('ch')">
                    <i class="bi bi-people"></i> Chambres
                  </a>
                  <ul>
                    <li><a class="nav-link" href="#" @click="setCurrentTab('ajoutch')">Ajouter Chambre</a></li>
                  </ul>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#" @click="setCurrentTab('clients')">
                    <i class="bi bi-gear"></i> Comptes clients
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#" @click="setCurrentTab('reservations')">
                    <i class="bi bi-calendar"></i> Réservations
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#" @click="setCurrentTab('offres')">
                    <i class="bi bi-calendar"></i> Offres
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#" @click="setCurrentTab('blogs')">
                    <i class="bi bi-calendar"></i> Blogs
                  </a>
                  <ul>
                    <li><a class="nav-link" href="#" @click="setCurrentTab('ajoutbg')">Ajouter Blog</a></li>
                  </ul>
                </li>                <li class="nav-item">
                  <a class="nav-link" href="#" @click="setCurrentTab('settings')">
                    <i class="bi bi-gear"></i> Paramètres
                  </a>
                </li>
              </ul>
            </div>
          </nav>
        </div>
        <div class="col-lg-10 col-md-9 col-sm-8">
          <component :is="currentTabComponent"></component>
        </div>
      </div>
    </main>
  </div>
</template>

<script>
import MainDash from './Admin/MainDash.vue';
import GestionHebergements from './Admin/GestionHebergements.vue';
import ClientList from './Admin/ClientList.vue';
import ParametresPage from './Admin/ParametresPage.vue';
import AjoutHeberg from './Admin/AjoutHeberg.vue';
import GestionChambres from './Admin/GestionChambres.vue';
import AjoutChambre from './Admin/AjoutChambre.vue';
import ReservationsList from './Admin/ReservationsList.vue';
import OffreComp from './Admin/OffreComp.vue';
import AjoutBlog from './Admin/AjoutBlog.vue';
import GestionBlog from './Admin/GestionBlog.vue';
export default {
  components: {
    MainDash,
    GestionHebergements,
    ClientList,
    ParametresPage,
    AjoutHeberg,
    GestionChambres,
    AjoutChambre,
    ReservationsList,
    OffreComp,
    AjoutBlog,
    GestionBlog,
  },
  data() {
    return {
      currentTab: 'dashboard',
      user: JSON.parse(localStorage.getItem('user')),
    };
  },
  computed: {
    currentTabComponent() {
      switch (this.currentTab) {
        case 'dashboard':
          return 'MainDash';
        case 'heb':
          return 'GestionHebergements';
        case 'clients':
          return 'ClientList';
        case 'settings':
          return 'ParametresPage';
        case 'ajoutheb':
          return 'AjoutHeberg';
        case 'ch':
          return 'GestionChambres';
        case 'ajoutch':
          return 'AjoutChambre';
        case 'reservations':
          return 'ReservationsList';
        case 'offres':
          return 'OffreComp';
        case 'blogs':
          return 'GestionBlog';
        case 'ajoutbg':
          return 'AjoutBlog';
        default:
          return 'div';
      }
    },
    userName() {
      return this.user ? `${this.user.prenom} ${this.user.nom}` : 'Admin';
    },
    profileImage() {
      const gender = this.user ? this.user.genre : 'H';
      return gender === 'H' ? 'https://i.imgur.com/uoEVFOO.png' : 'https://i.imgur.com/rY9l5m5.png';
    },
  },
  methods: {
    setCurrentTab(tab) {
      this.currentTab = tab;
    },
    logout() {
      localStorage.clear(); 
      this.$router.push({ name: 'AccueilPage' });
    },
  },
};

</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Tilt+Warp&display=swap');

.admin-dashboard {
  font-family: 'Arial', sans-serif;
}

.navbar {
  background-color: white; 
}
.navbar-brand{
  font-family: 'Tilt Warp', sans-serif;
  font-size: 30px;
  letter-spacing: 2px;
  background: linear-gradient(to right, lightblue, lightyellow); 
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;

}
.navbar .navbar-brand, .navbar .nav-link {
  color: #fff;
}
.navbar .dropdown-item{
  color: #333;
}

.navbar .nav-link.active {
  font-weight: bold;
}

.navbar .form-control {
  border: none;
}

.navbar .btn-outline-light {
  color: #fff;
  border-color: #fff;
}

.navbar .btn-outline-light:hover {
  background-color: #004080;
}

.sidebar {
  margin-top: 30px;
  background-color: #003366; 
  color: #fff; 
}

.sidebar .nav-link {
  color: #fff;
}

.sidebar .nav-link.active {
  font-weight: bold;
  background-color: #002244; 
}

.sidebar .nav-link:hover {
  background-color: #004080; 
}

.footer {
  position: fixed;
  bottom: 0;
  width: 100%;
  background-color: #003366; 
  color: #fff;
}

.avatarimg{
  width: 20%;
  margin-left: 20px;
}
</style>
