<template>
  <div class="pgimg">
    <div class="container">
      <div class="login-form">
        <h2>Formulaire de connexion</h2>
        <p>Entrez vos identifiants pour vous connecter.</p>

        <form @submit.prevent="handleSubmit">
          <div class="form-group">
            <label for="email">Adresse email:</label>
            <input
              type="email"
              class="form-control"
              id="email"
              v-model="email"
              placeholder="Entrez votre adresse email"
              required
            />
          </div>

          <div class="form-group">
            <label for="password">Mot de passe:</label>
            <input
              type="password"
              class="form-control"
              id="password"
              v-model="password"
              placeholder="Entrez votre mot de passe"
              required
            />
          </div>

          <button type="submit" class="btn btn-primary">Se connecter</button>
        </form>

        <div v-if="alertMessage" :class="`alert ${alertType}`" role="alert">
          {{ alertMessage }}
        </div>

        <div class="links">
          <router-link to="/signup">Tu n'as pas de compte ? <u>Créer un.</u></router-link>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'LoginPage',
  data() {
    return {
      email: '',
      password: '',
      alertMessage: '',  
      alertType: ''      
    };
  },
  methods: {
    async handleSubmit() {
      localStorage.clear();

      try {
        const response = await axios.post('http://127.0.0.1:8000/api/login', {
          email: this.email,
          password: this.password
        });

        localStorage.setItem('user', JSON.stringify(response.data.user));

        if (response.data.user.IDCARD === null) {
          this.$router.push('/admin-dashboard');
        } else {
          this.$router.push('/client-dashboard');
        }
      } catch (error) {
        this.alertType = 'alert-danger';
        if (error.response && error.response.data && error.response.data.error) {
          this.alertMessage = error.response.data.error;
        } else {
          this.alertMessage = 'Erreur lors de l\'authentification';
        }
      }
    }
  }
};
</script>

<style scoped>
.pgimg {
  background-image: url(../../assets/images/2cdbc33fb30d2588cab768c4bbd45473d5223cf8.jpg);
  background-size: cover;
  background-position: center;
  height: 100vh;
}

.container {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  max-width: 400px;
  padding: 30px;
  background-color: #fff;
  border-radius: 10px;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
  text-align: left;
}

.login-form {
  text-align: center;
}

.login-form h2 {
  margin-bottom: 20px;
}

.login-form p {
  font-size: 14px;
  color: #666;
}

.login-form input {
  width: 100%;
  padding: 12px;
  margin-bottom: 10px;
  border: 1px solid #ccc;
  border-radius: 4px;
}

.login-form button {
  background-color: #007bff;
  color: #fff;
  padding: 12px 20px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

.login-form .links {
  margin-top: 10px;
  text-align: center;
}

.login-form .links a {
  color: #666;
  text-decoration: none;
}

.alert {
  margin-top: 20px;
  padding: 10px;
  border-radius: 4px;
}

.alert-success {
  background-color: #d4edda;
  color: #155724;
}

.alert-danger {
  background-color: #f8d7da;
  color: #721c24;
}
</style>
