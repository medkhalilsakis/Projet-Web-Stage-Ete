<template>
    <div class="blog-form">
      <div class="form-container">
        <h2>{{ isEditing ? 'Modifier' : 'Ajouter' }} un Blog</h2>
        <form @submit.prevent="isEditing ? updateBlog() : addBlog()">
          <div>
            <label for="titre">Titre</label>
            <input type="text" id="titre" v-model="form.titre" required />
          </div>
          <div>
            <label for="image">Images</label>
            <input type="text" id="image" v-model="form.image" required />
          </div>
          <div>
            <label for="date">Date</label>
            <input type="date" id="date" v-model="form.date" required />
          </div>
          <div>
            <label for="description">Description</label>
            <textarea id="description" v-model="form.description" required></textarea>
          </div>
          <div>
            <label for="categories">Catégories</label>
            <input type="text" id="categories" v-model="form.categories" required />
          </div>
          <div>
            <label for="tags">Tags</label>
            <input type="text" id="tags" v-model="form.tags" required />
          </div>
          <button type="submit">{{ isEditing ? 'Mettre à jour' : 'Ajouter' }}</button>
        </form>
      </div>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  import Swal from 'sweetalert2';
  
  export default {
    data() {
      return {
        form: {
          titre: '',
          image: '',
          date: '',
          description: '',
          categories: '',
          tags: ''
        },
        isEditing: false,
        currentBlogId: null
      };
    },
    methods: {
      addBlog() {
        axios.post('http://127.0.0.1:8000/api/blogs', this.form)
          .then(response => {
            console.log(response);
            this.resetForm();
            Swal.fire({
              icon: 'success',
              title: 'Blog ajouté',
              text: 'Le blog a été ajouté avec succès!',
            });
          })
          .catch(error => {
            console.error('Erreur lors de l\'ajout du blog:', error);
            Swal.fire({
              icon: 'error',
              title: 'Erreur',
              text: 'Une erreur est survenue lors de l\'ajout du blog.',
            });
          });
      },
      updateBlog() {
        axios.put(`http://127.0.0.1:8000/api/blogs/${this.currentBlogId}`, this.form)
          .then(response => {
            console.log(response);
            this.resetForm();
            Swal.fire({
              icon: 'success',
              title: 'Blog mis à jour',
              text: 'Le blog a été mis à jour avec succès!',
            });
          })
          .catch(error => {
            console.error('Erreur lors de la mise à jour du blog:', error);
            Swal.fire({
              icon: 'error',
              title: 'Erreur',
              text: 'Une erreur est survenue lors de la mise à jour du blog.',
            });
          });
      },
      resetForm() {
        this.form = {
          titre: '',
          image: '',
          date: '',
          description: '',
          categories: '',
          tags: ''
        };
        this.isEditing = false;
        this.currentBlogId = null;
      }
    }
  };
  </script>
  
  <style scoped>
  .blog-form {
    display: flex;
    justify-content: center;
    padding: 20px;
  }
  
  .form-container {
    background-color: #ffffff;
    border: 1px solid #ddd;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    padding: 20px;
    max-width: 600px;
    width: 100%;
  }
  
  .form-container h2 {
    text-align: center;
    margin-bottom: 20px;
  }
  
  .form-container form {
    display: flex;
    flex-direction: column;
    gap: 10px;
  }
  
  .form-container form input,
  .form-container form textarea {
    padding: 10px;
    border-radius: 4px;
    border: 1px solid #ddd;
    width: 100%;
  }
  
  .form-container form button {
    align-self: center;
    background-color: #28a745;
    color: #fff;
    border: none;
    padding: 10px 20px;
    cursor: pointer;
    border-radius: 4px;
  }
  
  .form-container form button:hover {
    background-color: #218838;
  }
  </style>
  