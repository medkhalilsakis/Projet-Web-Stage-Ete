<template>
  <div class="pgimg">
    <div class="container">
      <div class="signup-form">
        <h2>Formulaire d'inscription</h2>
        <p>Veuillez remplir les informations ci-dessous pour créer un compte.</p>
        
        <div v-if="message" :class="['alert', {'alert-success': isSuccess, 'alert-danger': !isSuccess}]">
          {{ message }}
        </div>
        
        <form @submit.prevent="handleSubmit">
          <div class="form-row">
            <div class="form-group half-width">
              <label for="firstName">Prénom:</label>
              <input
                type="text"
                class="form-control"
                id="firstName"
                v-model="firstName"
                placeholder="Entrez votre prénom"
                required
              />
            </div>
            <div class="form-group half-width">
              <label for="lastName">Nom:</label>
              <input
                type="text"
                class="form-control"
                id="lastName"
                v-model="lastName"
                placeholder="Entrez votre nom"
                required
              />
            </div>
          </div>

        
          <div class="form-row">
            <div class="form-group half-width">
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
            <div class="form-group half-width">
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
          </div>

          <div class="form-row">
            <div class="form-group half-width">
              <label for="nationality">Nationalité:</label>
              <select
                class="form-control"
                id="nationality"
                v-model="nationality"
                required
              >
                <option value="">Sélectionnez votre nationalité</option>
                <option v-for="country in countries" :key="country" :value="country">
                  {{ country }}
                </option>
              </select>
            </div>
            <div class="form-group half-width">
              <label for="identity">Numéro CIN ou Passeport:</label>
              <input
                type="text"
                class="form-control"
                id="identity"
                v-model="identity"
                placeholder="Entrez votre numéro CIN ou Passeport"
                required
              />
            </div>
          </div>

        
          <div class="form-row">
            <div class="form-group half-width">
              <label for="birthdate">Date de naissance:</label>
              <input
                type="date"
                class="form-control"
                id="birthdate"
                v-model="birthdate"
                :max="maxDate"
                required
              />
            </div>
            <div class="form-group half-width">
              <label for="gender">Genre:</label>
              <select
                class="form-control"
                id="gender"
                v-model="gender"
                required
              >
                <option value="H">Homme</option>
                <option value="F">Femme</option>
              </select>
            </div>
          </div>

        
          <button type="submit" class="btn btn-primary">Créer un compte</button>
        </form>

       
        <div class="links">
          <p>Vous avez déjà un compte? <u><router-link to="/login">Se connecter</router-link></u></p>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'SignUp',
  data() {
    return {
      firstName: '',
      lastName: '',
      birthdate: '',
      identity: '',
      nationality: '',
      email: '',
      password: '',
      gender: '',
      countries: [
        'France', 'Belgique', 'Canada', 'Suisse', 'Luxembourg', 'Maroc', 'Algérie', 'Tunisie',
        'États-Unis', 'Royaume-Uni', 'Chine', 'Japon', 'Inde', 'Brésil', 'Australie', 'Afrique du Sud'
      ],
      message: '',
      isSuccess: false
    };
  },
  computed: {
    maxDate() {
      const today = new Date();
      const minAgeDate = new Date(today.getFullYear() - 18, today.getMonth(), today.getDate());
      return minAgeDate.toISOString().split('T')[0];
    }
  },
  methods: {
    handleSubmit() {
      localStorage.clear();

      if (this.calculateAge(this.birthdate) < 18) {
        this.message = "Vous devez avoir au moins 18 ans pour vous inscrire.";
        this.isSuccess = false;
        return;
      }

      const userData = {
        nom: this.firstName,
        prenom: this.lastName,
        date_naiss: this.birthdate,
        IDCARD: this.identity,
        nationalite: this.nationality,
        email: this.email,
        password: this.password,
        genre: this.gender
      };

      fetch('http://127.0.0.1:8000/api/users', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify(userData)
      })
      .then(response => {
        if (!response.ok) {
          throw new Error('Erreur lors de la création du compte.');
        }
       
        return response.json();
      })
      .then(() => {
    
        this.message = "Utilisateur créé avec succès";
        this.isSuccess = true;

      
        setTimeout(() => {
          this.$router.push('/login');
        }, 3000);
      })
      .catch(error => {
    
        if (error.response && error.response.data && error.response.data.error) {
          this.message = error.response.data.error;
        } else {
          this.message = "Erreur lors de la création du compte.";
        }
        this.isSuccess = false;
      });
    },
    calculateAge(birthdate) {
      const birthDate = new Date(birthdate);
      const today = new Date();
      let age = today.getFullYear() - birthDate.getFullYear();
      const m = today.getMonth() - birthDate.getMonth();
      if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
        age--;
      }
      return age;
    }
  }
};
</script>

<style scoped>
.pgimg {
  background-image: url(../../assets/images/495388818.jpg);
  background-size: cover;
  background-position: center;
  height: 150vh;
}

.container {
  position: absolute;
  top: 10%;
  left: 50%;
  transform: translate(-50%, 0);
  max-width: 500px;
  padding: 30px;
  background-color: #fff;
  border-radius: 10px;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
  text-align: left;
  margin-top: 50px;
}

.signup-form {
  text-align: center;
}

.signup-form h2 {
  margin-bottom: 20px;
}

.signup-form p {
  font-size: 14px;
  color: #666;
}

.form-row {
  display: flex;
  justify-content: space-between;
  gap: 20px;
}

.half-width {
  flex: 1;
}

.signup-form input,
.signup-form select {
  width: 100%;
  padding: 12px;
  margin-bottom: 10px;
  border: 1px solid #ccc;
  border-radius: 4px;
}

.signup-form button {
  background-color: #007bff;
  color: #fff;
  padding: 12px 20px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

.alert {
  margin-top: 20px;
  padding: 10px;
  border-radius: 4px;
}

.alert-success {
  background-color: #d4edda;
  border-color: #c3e6cb;
  color: #155724;
}

.alert-danger {
  background-color: #f8d7da;
  border-color: #f5c6cb;
  color: #721c24;
}

.links {
  margin-top: 10px;
  text-align: center;
}

.links a {
  color: #666;
  text-decoration: none;
}
</style>
