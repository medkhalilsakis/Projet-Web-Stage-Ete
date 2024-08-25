<template>
    <div class="container my-5">
      <h2 class="text-center mb-4">Gestion des Offres</h2>
  
      <div class="card p-4 mb-4">
        <h3 v-if="editing" class="text-center">Modifier une Offre</h3>
        <h3 v-else class="text-center">Ajouter une Offre</h3>
        <form @submit.prevent="handleSubmit">
          <div class="mb-3">
            <label for="titre" class="form-label">Titre</label>
            <input type="text" v-model="form.titre" class="form-control" id="titre" required />
          </div>
          <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea v-model="form.description" class="form-control" id="description" rows="3" required></textarea>
          </div>
          <div class="mb-3">
            <label for="date_deb" class="form-label">Date de Début</label>
            <input type="date" v-model="form.date_deb" class="form-control" id="date_deb" required />
          </div>
          <div class="mb-3">
            <label for="date_fin" class="form-label">Date de Fin</label>
            <input type="date" v-model="form.date_fin" class="form-control" id="date_fin" required />
          </div>
          <div class="mb-3">
            <label for="image" class="form-label">Image URL</label>
            <input type="text" v-model="form.image" class="form-control" id="image" required />
          </div>
          <div class="text-center">
            <button type="submit" class="btn btn-primary">
              {{ editing ? "Mettre à Jour" : "Ajouter" }}
            </button>
            <button v-if="editing" @click="cancelEdit" type="button" class="btn btn-secondary ms-2">Annuler</button>
          </div>
        </form>
      </div>
  
     
      <div class="row">
        <div class="col-md-4" v-for="offre in offres" :key="offre.id_offre">
          <div class="card mb-4">
            <img :src="offre.image" class="card-img-top" alt="Offre Image" />
            <div class="card-body">
              <h5 class="card-title">{{ offre.titre }}</h5>
              <p class="card-text">{{ offre.description }}</p>
              <p class="card-text">
                <small class="text-muted">Du {{ offre.date_deb }} au {{ offre.date_fin }}</small>
              </p>
              <div class="d-flex justify-content-between">
                <button @click="editOffre(offre)" class="btn btn-warning btn-sm">Modifier</button>
                <button @click="confirmDeleteOffre(offre.id_offre)" class="btn btn-danger btn-sm">Supprimer</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </template>
  
  <script setup>
  import { ref, onMounted } from 'vue';
  import axios from 'axios';
  import Swal from 'sweetalert2';
  
  const offres = ref([]);
  const form = ref({
    id_offre: '',
    titre: '',
    description: '',
    date_deb: '',
    date_fin: '',
    image: '',
  });
  const editing = ref(false);
  
  const fetchOffres = async () => {
    try {
      const response = await axios.get('http://127.0.0.1:8000/api/offres');
      offres.value = response.data;
    } catch (error) {
      Swal.fire('Erreur', 'Erreur lors de la récupération des offres', 'error');
      console.error('Erreur lors de la récupération des offres:', error);
    }
  };
  
  const handleSubmit = async () => {
    try {
      if (editing.value) {
        await axios.put(`http://127.0.0.1:8000/api/offres/${form.value.id_offre}`, form.value);
        Swal.fire('Succès', 'Offre mise à jour avec succès', 'success');
      } else {
        await axios.post('http://127.0.0.1:8000/api/offres', form.value);
        Swal.fire('Succès', 'Offre ajoutée avec succès', 'success');
      }
      fetchOffres();
      resetForm();
    } catch (error) {
      Swal.fire('Erreur', 'Erreur lors de l\'enregistrement de l\'offre', 'error');
      console.error('Erreur lors de l\'enregistrement de l\'offre:', error);
    }
  };
  
  const editOffre = (offre) => {
    form.value = { ...offre };
    editing.value = true;
  };
  
  const confirmDeleteOffre = (id) => {
    Swal.fire({
      title: 'Êtes-vous sûr?',
      text: 'Cette action est irréversible!',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#d33',
      cancelButtonColor: '#3085d6',
      confirmButtonText: 'Oui, supprimer!',
      cancelButtonText: 'Annuler'
    }).then((result) => {
      if (result.isConfirmed) {
        deleteOffre(id);
      }
    });
  };
  
  const deleteOffre = async (id) => {
    try {
      await axios.delete(`http://127.0.0.1:8000/api/offres/${id}`);
      Swal.fire('Supprimé!', 'L\'offre a été supprimée avec succès.', 'success');
      fetchOffres();
    } catch (error) {
      Swal.fire('Erreur', 'Erreur lors de la suppression de l\'offre', 'error');
      console.error('Erreur lors de la suppression de l\'offre:', error);
    }
  };
  
  const cancelEdit = () => {
    resetForm();
  };
  
  const resetForm = () => {
    form.value = {
      id_offre: '',
      titre: '',
      description: '',
      date_deb: '',
      date_fin: '',
      image: '',
    };
    editing.value = false;
  };
  
  onMounted(() => {
    fetchOffres();
  });
  </script>
  
  <style scoped>
  .container {
    max-width: 800px;
    margin: auto;
  }
  
  .card-img-top {
    height: 200px;
    object-fit: cover;
  }
  
  .card-body {
    display: flex;
    flex-direction: column;
    justify-content: space-between;
  }
  
  .btn {
    width: 45%;
  }
  </style>
  