Vue.component('modal', { //modal
	template: `
      
	<transition enter-active-class="animated bounceInDown"
				leave-active-class="animated bounceOutUp">
		<div class="modal is-active">
			<div class="modal-card border border border-secondary">
				<div class="modal-card-head text-center bg-info">
					<div class="modal-card-title text-white">
						<slot name="head"></slot>
					</div>
					<button class="delete" @click="$emit('close')"></button>
				</div>
				<div class="modal-card-body">
					<slot name="body"></slot>
				</div>
				<div class="modal-card-foot">
					<slot name="foot"></slot>
				</div>
			</div>
		</div>
	</transition>
    `
})

var v = new Vue({
	el: '#app',
	data: {
		url: 'http://localhost:8089/',
		adicionarModal: false,
		editarModal: false,
		apagarModal: false,
		users: [],
		search: {text: '', email: ''},
		emptyResult: false,
		novoCadastro: {
			nome: '',
			sobrenome: '',
			sexo: '',
			nascimento: '',
			email: '',
			fone: '',
			foto: ''
		},
		idade: '',
		previewFoto: null,
		updtCadastro: {},
		formValidate: [],
		mensagemSucesso: '',

		//pagination
		currentPage: 0,
		rowCountPage: 5,
		totalCadastros: 0,
		pageRange: 2
	},
	computed: {
		phoneMask() {
			return this.novoCadastro.fone.replace(/\D/g, '').length > 10 ? '(##) # ####-####' : '(##) ####-####';
		},
		phoneMaskUpdate() {
			return this.updtCadastro.fone.replace(/\D/g, '').length > 10 ? '(##) # ####-####' : '(##) ####-####';
		},
	},
	created() {
		this.buscaTodos();
	},
	methods: {
		calculaIdade(dat) {
			var dt = dat;
			if (dt) {
				var dts = dt.split("-");
				var d = new Date,
					ano_atual = d.getFullYear(),
					mes_atual = d.getMonth() + 1,
					dia_atual = d.getDate(),
					ano = +dts[0],
					mes = +dts[1],
					dia = +dts[2],
					idade = ano_atual - ano;


				if (ano >= 1900)
				{
					if (mes_atual < mes || mes_atual === mes && dia_atual < dia) {
						idade--;
					}
					this.idade = "Idade: " + (idade < 0 ? 0 : idade);
					return;
				}
			}
			this.idade = "Idade: -";
		},
		buscaTodos(order) {
			order = order || 'id'
			axios.get(this.url + "cadastro/buscaTodos?order="+order).then(function (response) {
				if (response.data.cadastros == null) {
					v.noResult()
				} else {
					v.getData(response.data.cadastros);
				}
			})
		},
		searchCadastro(campo) {
			campo = campo || 'nome'
			var formData = v.formData(v.search);
			axios.post(this.url + "cadastro/searchCadastro?campo="+campo, formData).then(function (response) {
				if (response.data.cadastros == null) {
					v.noResult()
				} else {
					v.getData(response.data.cadastros);

				}
			})
		},
		adicionaCadastro() {
			var formData = v.formData(v.novoCadastro);
			formData.append('imagem', document.querySelector('input[name="imagem"]').files[0]);
			axios.post(this.url + "cadastro/adicionaCadastro", formData, {
				headers: {
					'Content-Type': 'multipart/form-data'
				}
			}).then(function (response) {
				if (response.data.error) {
					v.formValidate = response.data.msg;
				} else {
					v.mensagemSucesso = response.data.msg;
					v.clearAll();
					v.clearMSG();
				}
			})
		},
		atualizaCadastro() {
			var formData = v.formData(v.updtCadastro);
			formData.append('imagem', document.querySelector('input[name="imagem"]').files[0]);
			axios.post(this.url + "cadastro/atualizaCadastro", formData, {
				headers: {
					'Content-Type': 'multipart/form-data'
				}
			}).then(function (response) {
				if (response.data.error) {
					v.formValidate = response.data.msg;
				} else {
					v.mensagemSucesso = response.data.success;
					v.clearAll();
					v.clearMSG();

				}
			})
		},
		removeCadastro() {
			var formData = v.formData(v.updtCadastro);
			axios.post(this.url + "cadastro/removeCadastro", formData).then(function (response) {
				if (!response.data.error) {
					v.mensagemSucesso = response.data.success;
					v.clearAll();
					v.clearMSG();
				}
			})
		},
		formData(obj) {
			var formData = new FormData();
			for (var key in obj) {
				formData.append(key, obj[key]);
			}
			return formData;
		},
		getData(users) {
			v.emptyResult = false; // become false if has a record
			v.totalCadastros = users.length //get total of user
			v.users = users.slice(v.currentPage * v.rowCountPage, (v.currentPage * v.rowCountPage) + v.rowCountPage);

			// if the record is empty, go back a page
			if (v.users.length == 0 && v.currentPage > 0) {
				v.pageUpdate(v.currentPage - 1)
				v.clearAll();
			}
		},

		selectCadastro(user) {
			v.updtCadastro = user;
			this.calculaIdade(user.nascimento)
		},
		clearMSG() {
			setTimeout(function () {
				v.mensagemSucesso = ''
			}, 3000); // disappearing message success in 2 sec
		},
		clearAll() {
			v.novoCadastro = {
				nome: '',
				sobrenome: '',
				sexo: '',
				nascimento: '',
				email: '',
				fone: '',
				foto: ''
			};
			v.idade = '';
			v.previewFoto = null;
			v.formValidate = false;
			v.adicionarModal = false;
			v.editarModal = false;
			v.apagarModal = false;
			v.refresh()

		},
		noResult() {

			v.emptyResult = true;  // become true if the record is empty, print 'No Record Found'
			v.users = null
			v.totalCadastros = 0

		},
		imgFoto(value) {
			return v.url + '' + value + ''
		},
		mudaFoto(event, tipo) {
			// console.log("==>mudafoto", tipo, event, this.novoCadastro)
			// return v.url + '' + value + ''
			const file = event.target.files[0];
			if (file) {
				const reader = new FileReader();
				reader.onload = (e) => {
					if (tipo === 'atualiza') {
						document.getElementById('previewFoto').src = e.target.result;
					} else {
						this.previewFoto = e.target.result;
					}
				}
				reader.readAsDataURL(file);
			}
		},
		pageUpdate(pageNumber) {
			v.currentPage = pageNumber;
			v.refresh()
		},
		refresh() {
			v.search.text ? v.searchCadastro() : v.buscaTodos(); //for preventing

		},
		validatePhone() {
			// Remove espaços e caracteres não numéricos
			const cleanedPhone = this.novoCadastro.fone; //.replace(/\D/g, '');

			// Verifica se o telefone tem 8 ou 9 dígitos
			if (/^\d{10,11}$/.test(cleanedPhone)) {
				this.error = '';
			} else {
				this.error = 'O telefone deve ter 10 ou 11 dígitos.';
			}

			// Atualiza o valor do telefone para o valor limpo (opcional)
			this.novoCadastro.fone = cleanedPhone;
		},
	}
})
