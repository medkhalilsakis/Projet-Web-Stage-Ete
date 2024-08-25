<template>
    <div class="blog-manager">
      <div class="blog-list">
        <h2>Liste des Blogs</h2>
        <div v-if="blogs.length" class="blog-cards">
          <div v-for="blog in blogs" :key="blog.id" class="blog-card">
            <div class="blog-images">
              <img v-for="url in blog.image.split(',')" :src="url" :key="url" class="blog-image" />
            </div>
            <div class="blog-details">
              <h5>{{ blog.titre }}</h5>
              <p v-html="formatDescription(blog.description)"></p>
              <small><b>Catégories:</b> {{ blog.categories }}</small>
              <br>
              <small><b>Tags:</b> {{ blog.tags }}</small>
              <br>
              <small><b>Date:</b> {{ formatDate(blog.date) }}</small>
            </div>
            <div class="blog-actions">
              <button @click="showEditPopup(blog)">Modifier</button>
              <button @click="deleteBlog(blog.id)">Supprimer</button>
            </div>
          </div>
        </div>
        <p v-else>Aucun blog disponible.</p>
      </div>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  import Swal from 'sweetalert2';
  
  export default {
    data() {
      return {
        blogs: [],
        form: {
          titre: '',
          image: '',
          date: '',
          description: '',
          categories: '',
          tags: ''
        },
        currentBlogId: null
      };
    },
    methods: {
      fetchBlogs() {
        axios.get('http://127.0.0.1:8000/api/blogs')
          .then(response => {
            this.blogs = response.data;
          })
          .catch(error => {
            console.error('Erreur lors de la récupération des blogs:', error);
          });
      },
      formatDate(date) {
        return new Date(date).toISOString().split('T')[0];
      },
      formatDescription(description) {
        return description.replace(/<<([^>>]+)>>/g, '<strong>$1</strong>');
      },
      showEditPopup(blog) {
        axios.get(`http://127.0.0.1:8000/api/blogs/${blog.id}`)
          .then(response => {
            this.form = response.data;
            this.currentBlogId = blog.id;
            Swal.fire({
              title: 'Modifier le Blog',
              html: `
                <form id="edit-blog-form">
                  <div class="form-group">
                    <label for="titre">Titre</label>
                    <input type="text" id="titre" class="swal2-input" value="${this.form.titre}">
                  </div>
                  <div class="form-group">
                    <label for="date">Date</label>
                    <input type="date" id="date" class="swal2-input" value="${this.formatDate(this.form.date)}">
                  </div>
                  <div class="form-group">
                    <label for="categories">Catégories</label>
                    <input type="text" id="categories" class="swal2-input" value="${this.form.categories}">
                  </div>
                  <div class="form-group">
                    <label for="tags">Tags</label>
                    <input type="text" id="tags" class="swal2-input" value="${this.form.tags}">
                  </div>
                  <div class="form-group">
                    <label for="description">Description</label>
                    <textarea id="description" class="swal2-textarea">${this.form.description}</textarea>
                  </div>
                  <div class="form-group">
                    <label for="image">Image URL</label>
                    <input type="text" id="image" class="swal2-input" value="${this.form.image}">
                  </div>
                </form>
              `,
              preConfirm: () => {
                return {
                  titre: Swal.getPopup().querySelector('#titre').value,
                  date: Swal.getPopup().querySelector('#date').value,
                  categories: Swal.getPopup().querySelector('#categories').value,
                  tags: Swal.getPopup().querySelector('#tags').value,
                  description: Swal.getPopup().querySelector('#description').value,
                  image: Swal.getPopup().querySelector('#image').value
                };
              },
              confirmButtonText: 'Mettre à jour',
              showCancelButton: true
            }).then((result) => {
              if (result.isConfirmed) {
                axios.put(`http://127.0.0.1:8000/api/blogs/${this.currentBlogId}`, result.value)
                  .then(response => {
                    const index = this.blogs.findIndex(blog => blog.id === this.currentBlogId);
                    this.blogs.splice(index, 1, response.data);
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
              }
            });
          })
          .catch(error => {
            console.error('Erreur lors de la récupération des détails du blog:', error);
          });
      },
      deleteBlog(id) {
        Swal.fire({
          title: 'Êtes-vous sûr?',
          text: "Vous ne pourrez pas annuler cette action!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Oui, supprimer!'
        }).then((result) => {
          if (result.isConfirmed) {
            axios.delete(`http://127.0.0.1:8000/api/blogs/${id}`)
              .then(response => {
                console.log(response);
                this.blogs = this.blogs.filter(blog => blog.id !== id);
                Swal.fire(
                  'Supprimé!',
                  'Le blog a été supprimé.',
                  'success'
                );
              })
              .catch(error => {
                console.error('Erreur lors de la suppression du blog:', error);
                Swal.fire({
                  icon: 'error',
                  title: 'Erreur',
                  text: 'Une erreur est survenue lors de la suppression du blog.',
                });
              });
          }
        });
      }
    },
    mounted() {
      this.fetchBlogs();
    }
  };
  </script>
<style scoped>
.blog-manager {
  max-width: 1200px;
  margin: 0 auto;
  padding: 20px;
}

h1, h2 {
  text-align: center;
  margin-bottom: 20px;
}

.blog-list {
  margin-bottom: 40px;
}

.blog-cards {
  display: flex;
  flex-wrap: wrap;
  gap: 20px;
}

.blog-card {
  display: flex;
  flex-direction: column;
  background-color: #f9f9f9;
  border-radius: 8px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
  overflow: hidden;
  width: calc(33% - 20px);
  position: relative;
}

.blog-images {
  display: flex;
  gap: 5px;
  overflow-x: auto;
  width: 100%;
}

.blog-image {
  width: 100%;
  height: auto;
  object-fit: cover;
}

.blog-details {
  padding: 15px;
  flex: 1;
}

.blog-actions {
  display: flex;
  justify-content: space-between;
  padding: 10px;
  background-color: #f1f1f1;
  border-top: 1px solid #ddd;
}

.blog-actions button {
  background-color: #007bff;
  color: #fff;
  border: none;
  padding: 10px;
  cursor: pointer;
  border-radius: 4px;
}

.blog-actions button:hover {
  background-color: #0056b3;
}
</style>
