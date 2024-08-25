<template>
  <div class="container mt-4">
    <h2 class="page-title">Gestion des Hébergements</h2>
    <table class="table table-hover table-striped">
      <thead class="thead-dark">
        <tr>
          <th scope="col">Code Hébergement</th>
          <th scope="col">Nom</th>
          <th scope="col">Type</th>
          <th scope="col">Adresse</th>
          <th scope="col">Nombre de Chambres</th>
          <th scope="col">Images</th>
          <th scope="col">Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="hebergement in hebergements" :key="hebergement.id">
          <td>{{ hebergement.code_hb }}</td>
          <td>{{ hebergement.nom }}</td>
          <td>{{ hebergement.type }}</td>
          <td>{{ hebergement.adresse }}</td>
          <td>{{ hebergement.nbr_de_chambres }}</td>
          <td>
            <div v-if="hebergement.images && hebergement.images.length > 0">
              <div v-for="image in hebergement.images" :key="image.id" class="image-container">
                <img :src="image.url" alt="Image" class="img-thumbnail img-preview">
                <button class="btn delete-btn" @click="deleteImage(hebergement.code_hb, image.id)">
                  <img src="https://i.imgur.com/nKwRyAd.png" alt="Delete" class="delete-icon">
                </button>
              </div>
            </div>
            <div v-else>
              <img :src="defaultImage" alt="Pas d'image disponible" class="img-thumbnail img-preview">
            </div>
          </td>
          <td>
            <button class="btn btn-warning btn-sm action-btn" @click="openEditModal(hebergement)">Edit</button>
            <button class="btn btn-danger btn-sm action-btn" @click="confirmDelete(hebergement.code_hb)">Delete</button>
            <span>
              <button class="btn btn-success btn-sm action-btn" @click="triggerFileInput(hebergement.code_hb)">
              Add images
            </button>
            <input
              type="file"
              :id="'fileInput-' + hebergement.code_hb"
              @change="handleFileUpload($event, hebergement.code_hb)"
              style="display: none"
              multiple
            >
            </span>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>



<script>
import axios from 'axios';
import Swal from 'sweetalert2';

export default {
  data() {
    return {
      formData: {
        code_hb: '',
        nom: '',
        type: '',
        adresse: '',
        nbr_de_chambres: '',
        description: '',
        pts_forts: '',
        num_tel: '',
      },
      hebergements: [],
      defaultImage: 'https://www.mjc-castanet-tolosan.fr/wp-content/uploads/2016/06/Pas-dimage-disponible1-e1466657277567.jpg',
      selectedFiles: [],
      currentCodeHb: '', 
    };
  },
  mounted() {
    this.fetchHebergements();
  },
  methods: {
    fetchHebergements() {
      axios.get('http://127.0.0.1:8000/api/hebergements')
      .then(response => {
        this.hebergements = response.data.map(hebergement => ({
          ...hebergement,
          images: []
        }));
        this.hebergements.forEach(hebergement => {
          this.fetchImagesByCodeHb(hebergement.code_hb);
        });
      })
      .catch(error => {
        console.error('Error fetching hebergements:', error);
      });
    },
    fetchImagesByCodeHb(code_hb) {
    axios.get(`http://127.0.0.1:8000/api/images/${code_hb}`)
    .then(response => {
      const hebergement = this.hebergements.find(h => h.code_hb === code_hb);
      if (hebergement) {
        hebergement.images = response.data.map(image => ({
          ...image,
          url: this.getFullImageUrl(image.path)
        }));
      }
    })
    .catch(error => {
      if (error.response && error.response.status === 404) {
        console.warn(`Aucune image trouvée pour l'hébergement ${code_hb}`);
        const hebergement = this.hebergements.find(h => h.code_hb === code_hb);
        if (hebergement) {
          hebergement.images = [];
        }
      } else {
        console.error(`Erreur lors de la récupération des images pour ${code_hb}:`, error);
      }
    });
    },
    getFullImageUrl(path) {
      return `http://127.0.0.1:8000/storage/uploads/images/${path}`;
    },
    openEditModal(hebergement) {
  this.formData = { ...hebergement };

  Swal.fire({
    title: 'Modifier Hébergement',
    html: `
      <form id="swal-form">
        <!-- Champ pour Code Hébergement -->
        <div class="form-group">
          <label for="code_hb">Code Hébergement</label>
          <input type="text" id="swal-input-code_hb" class="form-control" value="${hebergement.code_hb}" disabled>
        </div>
        <!-- Champ pour Nom -->
        <div class="form-group">
          <label for="nom">Nom</label>
          <input type="text" id="swal-input-nom" class="form-control" value="${hebergement.nom}">
        </div>
        <!-- Champ pour Type -->
        <div class="form-group">
          <label for="type">Type</label>
          <input type="text" id="swal-input-type" class="form-control" value="${hebergement.type}">
        </div>
        <!-- Champ pour Adresse -->
        <div class="form-group">
          <label for="adresse">Adresse</label>
          <input type="text" id="swal-input-adresse" class="form-control" value="${hebergement.adresse}">
        </div>
        <!-- Champ pour Nombre de Chambres -->
        <div class="form-group">
          <label for="nbr_de_chambres">Nombre de Chambres</label>
          <input type="number" id="swal-input-nbr_de_chambres" class="form-control" value="${hebergement.nbr_de_chambres}">
        </div>
        <!-- Champ pour Description -->
        <div class="form-group">
          <label for="description">Description</label>
          <textarea id="swal-input-description" class="form-control">${hebergement.description || ''}</textarea>
        </div>
        <!-- Champ pour Points Forts -->
        <div class="form-group">
          <label for="pts_forts">Points Forts (séparés par des virgules)</label>
          <textarea id="swal-input-pts_forts" class="form-control">${hebergement.pts_forts || ''}</textarea>
        </div>
        <!-- Champ pour Numéro de Téléphone -->
        <div class="form-group">
          <label for="num_tel">Numéro de Téléphone</label>
          <input type="tel" id="swal-input-num_tel" class="form-control" value="${hebergement.num_tel || ''}">
        </div>
      </form>
    `,
    showCancelButton: true,
    confirmButtonText: 'Sauvegarder',
    preConfirm: () => {
      const nom = document.getElementById('swal-input-nom').value;
      const type = document.getElementById('swal-input-type').value;
      const adresse = document.getElementById('swal-input-adresse').value;
      const nbr_de_chambres = document.getElementById('swal-input-nbr_de_chambres').value;
      const description = document.getElementById('swal-input-description').value;
      const pts_forts = document.getElementById('swal-input-pts_forts').value;
      const num_tel = document.getElementById('swal-input-num_tel').value;

      if (!nom || !type || !adresse || !nbr_de_chambres) {
        Swal.showValidationMessage('Veuillez remplir tous les champs obligatoires.');
        return false;
      }

      return {
        nom,
        type,
        adresse,
        nbr_de_chambres,
        description,
        pts_forts,
        num_tel,
      };
    }
  }).then((result) => {
    if (result.isConfirmed) {
      const { nom, type, adresse, nbr_de_chambres, description, pts_forts, num_tel } = result.value;
      const updatedHebergement = {
        ...hebergement,
        nom,
        type,
        adresse,
        nbr_de_chambres,
        description,
        pts_forts,
        num_tel,
      };

      axios.put(`http://127.0.0.1:8000/api/hebergements/${hebergement.code_hb}`, updatedHebergement)
        .then(response => {
          console.log(response.data);
          Swal.fire('Succès', 'L\'hébergement a été mis à jour avec succès.', 'success');
          this.fetchHebergements(); 
        })
        .catch(error => {
          console.error('Erreur lors de la mise à jour de l\'hébergement:', error);
          Swal.fire('Erreur', 'Erreur lors de la mise à jour de l\'hébergement.', 'error');
        });
    }
  });
    },
    confirmDelete(code_hb) {
      Swal.fire({
        title: 'Êtes-vous sûr ?',
        text: "Cette action est irréversible !",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Oui, supprimer',
        cancelButtonText: 'Annuler',
      }).then((result) => {
        if (result.isConfirmed) {
          this.deleteHebergement(code_hb);
        }
      });
    },
    deleteHebergement(code_hb) {
  axios.get(`http://127.0.0.1:8000/api/images/existence/${code_hb}`)
    .then(response => {
      if (response.data.exists) {
        return axios.delete(`http://127.0.0.1:8000/api/images/${code_hb}`)
          .then(() => {
            return axios.delete(`http://127.0.0.1:8000/api/hebergements/${code_hb}`);
          });
      } else {
        return axios.delete(`http://127.0.0.1:8000/api/hebergements/${code_hb}`);
      }
    })
    .then(() => {
      Swal.fire('Succès', 'L\'hébergement a été supprimé avec succès.', 'success');
      this.fetchHebergements();
    })
    .catch(error => {
      console.error('Erreur lors de la suppression:', error);
      Swal.fire('Erreur', 'Une erreur s\'est produite lors de la suppression.', 'error');
    });
    },
    deleteImage(code_hb, imageId) {
      Swal.fire({
        title: 'Êtes-vous sûr ?',
        text: "Cette image sera supprimée !",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Oui, supprimer',
        cancelButtonText: 'Annuler',
      }).then((result) => {
        if (result.isConfirmed) {
          axios.delete(`http://127.0.0.1:8000/api/images/deletebyID/${imageId}`)
            .then(() => {
              const hebergement = this.hebergements.find(h => h.code_hb === code_hb);
              if (hebergement) {
                hebergement.images = hebergement.images.filter(image => image.id !== imageId);
              }
              Swal.fire('Succès', 'L\'image a été supprimée avec succès.', 'success');
            })
            .catch(error => {
              console.error('Erreur lors de la suppression de l\'image:', error);
              Swal.fire('Erreur', 'Une erreur s\'est produite lors de la suppression de l\'image.', 'error');
            });
        }
      });
    },
    triggerFileInput(code_hb) {
      this.currentCodeHb = code_hb;
      document.getElementById(`fileInput-${code_hb}`).click();
    },
    handleFileUpload(event, code_hb) {
      const files = Array.from(event.target.files);
      this.selectedFiles = files.filter(file => file.size <= 1024 * 1024);

      if (this.selectedFiles.length > 0) {
        this.uploadImages(code_hb);
      } else {
        alert('Please select files that are less than 1MB.');
      }
    },
    async uploadImages(code_hb) {
      if (this.selectedFiles.length === 0) {
        alert('Please select at least one valid image.');
        return;
      }

      for (let i = 0; i < this.selectedFiles.length; i++) {
        const formData = new FormData();
        formData.append('image', this.selectedFiles[i]);
        formData.append('code_hb', code_hb);

        try {
          const response = await axios.post('http://127.0.0.1:8000/api/images', formData, {
            headers: {
              'Content-Type': 'multipart/form-data',
            },
          });

          const hebergement = this.hebergements.find(h => h.code_hb === code_hb);
          if (hebergement) {
            hebergement.images.push({
              id: response.data.id,
              url: this.getFullImageUrl(response.data.path)
            });
          }
        } catch (error) {
          console.error('Error uploading image:', error);
          alert('Failed to upload image.');
        }
      }

      alert('Images uploaded successfully!');
      this.selectedFiles = [];
      this.fetchHebergements();
    },
    imageUrl(path) {
        return `http://127.0.0.1:8000/storage/uploads/images/${path}`;
    },
  }
};
</script>

<style scoped>
.page-title {
  font-size: 1.5rem;
  font-weight: bold;
  color: #333;
  margin-bottom: 20px;
}

.table {
  border-radius: 8px;
  overflow: hidden;
  background-color: #fff;
}

.table th, .table td {
  padding: 12px;
  text-align: left;
}

.table-hover tbody tr:hover {
  background-color: #f5f5f5;
}

.table-striped tbody tr:nth-of-type(odd) {
  background-color: #f9f9f9;
}

.thead-dark th {
  background-color: #343a40;
  color: white;
}

.img-thumbnail {
  border: 1px solid #ddd;
  border-radius: 4px;
  padding: 4px;
  max-width: 100px;
  max-height: 100px;
  margin: 2px;
}

.img-preview {
  margin-right: 10px;
}

.image-container {
  position: relative;
  display: inline-block;
  margin: 5px;
}

.delete-btn {
  position: absolute;
  top: -15px;
  right: 5px;
  border: none;
  border-radius: 50%;
  padding: 5px;
  cursor: pointer;
  width: 24px;
  height: 24px;
}

.delete-icon {
  width: 20px;
}

</style>

