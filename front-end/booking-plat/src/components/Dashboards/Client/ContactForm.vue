<template>
    <div class="contact-container">
      <h2>Contactez-nous</h2>
      <form @submit.prevent="sendMessage" class="contact-form">
        <div class="form-group">
          <label for="name">Nom:</label>
          <input
            type="text"
            id="name"
            v-model="form.nom"
            :readonly="true"
          />
        </div>
        <div class="form-group">
          <label for="email">Email:</label>
          <input
            type="email"
            id="email"
            v-model="form.email"
            :readonly="true"
          />
        </div>
        <div class="form-group">
          <label for="message">Message:</label>
          <textarea
            id="message"
            v-model="form.message"
            rows="5"
            required
          ></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Envoyer</button>
      </form>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  import Swal from 'sweetalert2';
  
  export default {
    data() {
      return {
        form: {
          nom: '',
          email: '',
          message: '',
        },
      };
    },
    mounted() {
      this.loadUserData();
    },
    methods: {
      loadUserData() {
        const user = JSON.parse(localStorage.getItem('user'));
        if (user) {
          this.form.nom = user.nom;
          this.form.email = user.email;
        }
      },
      async sendMessage() {
        try {
          const response = await axios.post('http://127.0.0.1:8000/api/inbox', {
            nom: this.form.nom,
            email: this.form.email,
            message: this.form.message,
            etat: 0, // Toujours 0
          });
          console.log(response);
          Swal.fire({
            icon: 'success',
            title: 'Message envoyé!',
            text: 'Votre message a été envoyé avec succès.',
          });
          this.form.message = ''; 
        } catch (error) {
          Swal.fire({
            icon: 'error',
            title: 'Erreur',
            text: 'Une erreur est survenue lors de l\'envoi de votre message. Veuillez réessayer.',
          });
          console.error('Erreur lors de l\'envoi du message:', error);
        }
      },
    },
  };
  </script>
  
  <style scoped>
  .contact-container {
    max-width: 600px;
    margin: 0 auto;
    padding: 20px;
    background: #f9f9f9;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  }
  
  .contact-container h2 {
    margin-bottom: 20px;
    font-size: 24px;
    color: #333;
  }
  
  .contact-form .form-group {
    margin-bottom: 15px;
  }
  
  .contact-form .form-group label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
  }
  
  .contact-form .form-group input,
  .contact-form .form-group textarea {
    width: 100%;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 4px;
  }
  
  .contact-form .form-group input[readonly],
  .contact-form .form-group textarea[readonly] {
    background: #e9ecef;
  }
  
  .contact-form button {
    background: #007bff;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 4px;
    cursor: pointer;
    font-size: 16px;
  }
  
  .contact-form button:hover {
    background: #0056b3;
  }
  </style>
  