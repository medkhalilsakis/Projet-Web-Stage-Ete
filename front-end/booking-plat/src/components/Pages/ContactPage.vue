<template>
  <section class="img12">
    <div class="section-header">
      <div class="container">
        <h2>Contact Us</h2>
        <p>
          Reach out to us with ease through our "Contact Us" section, where we are committed to addressing your inquiries and providing assistance. Whether you have questions, feedback, or need support, our team is here to help. Explore our contact details below, including our physical address, phone number, and email, or send us a message directly through the form provided. Your satisfaction is our priority, and we look forward to connecting with you.
        </p>
      </div>
    </div>

    <div class="container">
      <div class="row">
        <div class="contact-info">
          <div class="contact-info-item">
            <div class="contact-info-icon">
              <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" class="bi bi-house-fill" viewBox="0 0 16 16">
  <path d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L8 2.207l6.646 6.647a.5.5 0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293z"/>
  <path d="m8 3.293 6 6V13.5a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 2 13.5V9.293z"/>
</svg>
            </div>

            <div class="contact-info-content">
              <h4>Address</h4>
              <p>
                Main Street 123,<br />
                New York, NY, USA, <br />
                55060
              </p>
            </div>
          </div>

          <div class="contact-info-item">
            <div class="contact-info-icon">
              <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" class="bi bi-telephone-fill" viewBox="0 0 16 16">
  <path fill-rule="evenodd" d="M1.885.511a1.745 1.745 0 0 1 2.61.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.68.68 0 0 0 .178.643l2.457 2.457a.68.68 0 0 0 .644.178l2.189-.547a1.75 1.75 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.6 18.6 0 0 1-7.01-4.42 18.6 18.6 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877z"/>
</svg>
            </div>

            <div class="contact-info-content">
              <h4>Phone</h4>
              <p>111-234-5678</p>
            </div>
          </div>

          <div class="contact-info-item">
            <div class="contact-info-icon">
              <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" class="bi bi-envelope-fill" viewBox="0 0 16 16">
  <path d="M.05 3.555A2 2 0 0 1 2 2h12a2 2 0 0 1 1.95 1.555L8 8.414zM0 4.697v7.104l5.803-3.558zM6.761 8.83l-6.57 4.027A2 2 0 0 0 2 14h12a2 2 0 0 0 1.808-1.144l-6.57-4.027L8 9.586zm3.436-.586L16 11.801V4.697z"/>
</svg>
            </div>

            <div class="contact-info-content">
              <h4>Email</h4>
              <p>contact@wanderwise.com</p>
            </div>
          </div>
        </div>

        <div class="contact-form">
          <form @submit.prevent="sendMessage">
            <h2>Send Message</h2>
            <div v-if="message" :class="{'success': isSuccess, 'error': !isSuccess}" class="response-message">
              {{ message }}
            </div>
            <div class="input-box">
              <input v-model="form.nom" type="text" required />
              <span>Full Name</span>
            </div>

            <div class="input-box">
              <input v-model="form.email" type="email" required />
              <span>Email</span>
            </div>

            <div class="input-box">
              <textarea v-model="form.message" required></textarea>
              <span>Type your Message...</span>
            </div>

            <div class="input-box">
              <input type="submit" value="Send" />
            </div>

            
          </form>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
import axios from 'axios';

export default {
  name: 'ContactForm',
  data() {
    return {
      form: {
        nom: '',
        email: '',
        message: ''
      },
      message: '',
      isSuccess: true
    };
  },
  methods: {
    async sendMessage() {
      try {
        const response = await axios.post('http://127.0.0.1:8000/api/inbox', this.form);
        console.log(response.data);
        this.message = 'Message sent successfully!';
        this.isSuccess = true;
        
        this.form.name = '';
        this.form.email = '';
        this.form.message = '';
      } catch (error) {
        if (error.response && error.response.data && error.response.data.error) {
          this.message = 'Failed to send message: ' + error.response.data.error;
        } else {
          this.message = 'Failed to send message.';
        }
        this.isSuccess = false;
      }
    }
  }
};
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap');

* {
  padding: 0;
  margin: 0;
  box-sizing: border-box;
  font-family: 'Poppins', sans-serif;
}

body {
  min-height: 100vh;
  width: 100%;
  display: flex;
  justify-content: center;
  align-items: center;
  background-size: cover;
  background-position: center;
  position: relative;
}
.img12{
  background-image: url(../../assets/images/contact.jpg);
}
.response-message {
  margin-top: 20px;
  padding: 10px;
  border-radius: 5px;
  font-size: 16px;
}

.response-message.success {
  color: #28a745; 
  border: 1px solid #28a745;
}

.response-message.error {
  color: #dc3545; 
  border: 1px solid #dc3545;
}

body::after {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  height: 100%;
  width: 100%;
  background-color: rgba(0, 0, 0, 0.8);
}

section {
  position: relative;
  z-index: 3;
  padding-top: 50px;
  padding-bottom: 50px;
}

.container {
  max-width: 1080px;
  margin-left: auto;
  margin-right: auto;
  padding-left: 20px;
  padding-right: 20px;
}

.section-header {
  margin-top:50px;
  margin-bottom: 50px;
  text-align: center;
}

.section-header h2 {
  color: #fff;
  font-weight: bold;
  font-size: 3em;
  margin-bottom: 20px;
}

.section-header p {
  color: #fff;
}

.row {
  display: flex;
  flex-wrap: wrap;
  align-items: center;
  justify-content: space-between;
}

.contact-info {
  width: 50%;
}

.contact-info-item {
  display: flex;
  margin-bottom: 30px;
}

.contact-info-icon {
  color: white;
  height: 70px;
  width: 70px;
  text-align: center;
  border-radius: 50%;
}

.contact-info-icon i {
  font-size: 30px;
  line-height: 70px;
}

.contact-info-content {
  margin-left: 20px;
}

.contact-info-content h4 {
  color: #1da9c0;
  font-size: 1.4em;
  margin-bottom: 5px;
}

.contact-info-content p {
  color: #fff;
  font-size: 1em;
}

.contact-form {
  background-color: #fff;
  padding: 40px;
  width: 45%;
  padding-bottom: 20px;
  padding-top: 20px;
}

.contact-form h2 {
  font-weight: bold;
  font-size: 2em;
  margin-bottom: 10px;
  color: #333;
}

.contact-form .input-box {
  position: relative;
  width: 100%;
  margin-top: 10px;
}

.contact-form .input-box input,
.contact-form .input-box textarea {
  width: 100%;
  padding: 5px 0;
  font-size: 16px;
  margin: 10px 0;
  border: none;
  border-bottom: 2px solid #333;
  outline: none;
  resize: none;
}

.contact-form .input-box span {
  position: absolute;
  left: 0;
  padding: 5px 0;
  font-size: 16px;
  margin: 10px 0;
  pointer-events: none;
  transition: 0.5s;
  color: #666;
}

.contact-form .input-box input:focus ~ span,
.contact-form .input-box textarea:focus ~ span {
  color: #e91e63;
  font-size: 12px;
  transform: translateY(-20px);
}

.contact-form .input-box input[type='submit'] {
  width: 100%;
  background: #00bcd4;
  color: #fff;
  border: none;
  cursor: pointer;
  padding: 10px;
  font-size: 18px;
  border: 1px solid #00bcd4;
  transition: 0.5s;
}

.contact-form .input-box input[type='submit']:hover {
  background: #fff;
  color: #00bcd4;
}

@media (max-width: 991px) {
  section {
    padding-top: 50px;
    padding-bottom: 50px;
  }

  .row {
    flex-direction: column;
  }

  .contact-info {
    margin-bottom: 40px;
    width: 100%;
  }

  .contact-form {
    width: 100%;
  }
  
}

</style>
