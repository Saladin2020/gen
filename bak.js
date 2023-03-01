const app = Vue.createApp({
    template: `
  <div>
    <div ref="editor"></div>
    <br>
    <button @click="saveContent" class="bg-blue-500 text-white p-2 rounded-lg">Save Content</button>
  </div>
`,
    data() {
        return {
            content: ""
        }
    },
    mounted() {
        ClassicEditor
            .create(this.$refs.editor,)
            .then(editor => {
                this.editor = editor;
            })
            .catch(error => {
                console.error(error);
            });
    },
    methods: {
        saveContent() {
            this.content = this.editor.getData();
            console.log(this.content);
            // you can also use this.content to send it to server or store it in localstorage
        }
    }
});
app.mount('#app');
      //console.log(Vue.version)