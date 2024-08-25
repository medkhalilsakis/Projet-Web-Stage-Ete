<template>
  <div id="app">
    <nav v-if="!$route.meta.hideNavbar" class="navbar bg-dark navbar-dark navbar-expand-md fixed-top">
      <div class="container">
        <a class="navbar-brand" href="/">Wanderwise</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#myTogglerNav"
          aria-controls="myTogglerNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="myTogglerNav">
          <div class="navbar-nav ml-auto pt-1">
            <router-link class="nav-item nav-link" to="/">Home</router-link>
            <router-link class="nav-item nav-link" to="/about">About Us</router-link>
            <router-link class="nav-item nav-link" to="/blog">Blog</router-link>
            <router-link class="nav-item nav-link" to="/contact">Contact</router-link>
            <router-link id="signup" class="nav-item nav-link" to="/signup">SignUp</router-link>
            <router-link id="login" class="nav-item nav-link" to="/login">Login</router-link>
            <div class="mb-1">
              <router-link to="/login" type="button" class="btn btn-primary pb-2 text-uppercase" data-toggle="modal"
                data-target="#servicesmodal">Book Now</router-link>
            </div>
          </div>
        </div>
      </div> 
    </nav>
    <router-view />
  </div>
</template>

<script>
// main.js or App.vue

export default {
  async mounted() {
    await this.checkExpiredReservations();
  },
  methods: {
    async checkExpiredReservations() {
  try {
    const response = await fetch('http://127.0.0.1:8000/api/reservations');
    
    if (!response.ok) {
      throw new Error('Failed to fetch reservations');
    }

    const data = await response.json();

    const reservations = data.reservations;

    if (!Array.isArray(reservations)) {
      throw new TypeError('Reservations data is not an array');
    }

    const today = new Date();

    for (const reservation of reservations) {
      const departureDate = new Date(reservation.date_dep);

      if (departureDate < today) {
        await fetch(`http://127.0.0.1:8000/api/reservations/${reservation.id_resv}`, {
          method: 'DELETE',
        });

        await fetch(`http://127.0.0.1:8000/api/chambres/dispo/${reservation.num_chambre}`, {
          method: 'PUT',
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify({ disponibilite: true }),
        });

        console.log(`Reservation ${reservation.id_resv} deleted and room ${reservation.num_chambre} set to available.`);
      }
    }
  } catch (error) {
    console.error('Error checking or updating reservations:', error);
  }
}


  },
};

</script>

<style>
#app{
  font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
}
#login{
  color: lightgreen;
}
#login:hover{
  color: lightseagreen;
}
#signup{
  color: lightblue;
}
#signup:hover{
  color:lightskyblue;
}
</style>
