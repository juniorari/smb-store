<!--add modal-->
<modal v-if="adicionarModal" @close="clearAll()">

	<h5 slot="head">Adicionar</h5>
	<div slot="body" class="row">
		<div class="col-md-6">
			<div class="form-group">
				<label>Nome</label>
				<input type="text" class="form-control" :class="{'is-invalid': formValidate.nome}" name="nome"
					   v-model="novoCadastro.nome">

				<div class="has-text-danger" v-html="formValidate.nome"></div>
			</div>
			<div class="form-group">
				<label>Sobrenome</label>
				<input type="text" class="form-control" :class="{'is-invalid': formValidate.sobrenome}" name="sobrenome"
					   v-model="novoCadastro.sobrenome">

				<div class="has-text-danger" v-html="formValidate.sobrenome"></div>
			</div>
			<div class="form-group">
				<label for="">Sexo</label><br>
				<select name="sexo" id="sexo" v-model="novoCadastro.sexo" class="form-control">
					<option value="">Selecione</option>
					<option value="M" :selected="{'selected':(novoCadastro.sexo == 'M')}">Masculino</option>
					<option value="F" :selected="{'selected':(novoCadastro.sexo == 'F')}">Feminino</option>
				</select>
				<div class="has-text-danger" v-html="formValidate.sexo"></div>
			</div>
			<div class="form-group">
				<label>Nascimento</label>
				<input type="date" class="form-control" :class="{'is-invalid': formValidate.nascimento}"
					   name="nascimento" id="nascimento"
					   @input="calculaIdade(novoCadastro.nascimento)"
					   v-model="novoCadastro.nascimento">
				<div class="has-text-danger" v-html="formValidate.nascimento"></div>
				<div>{{ idade }}</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<label>Email</label>
				<input type="text" class="form-control" :class="{'is-invalid': formValidate.email}" name="email"
					   v-model="novoCadastro.email">
				<div class="has-text-danger" v-html="formValidate.email"></div>
			</div>
			<div class="form-group">
				<label>Fone</label>
				<input type="text" class="form-control" :class="{'is-invalid': formValidate.fone}" name="fone"
					   id="phone"
					   v-mask="phoneMask"
					   @input="validatePhone"
					   v-model="novoCadastro.fone">
				<div class="has-text-danger" v-html="formValidate.fone"></div>
			</div>
			<div class="form-group">
				<label>Foto</label><br>
				<img v-if="previewFoto" :src="previewFoto" width='150' height="150">
				<div v-else>-</div>
                <input type="file" @change="mudaFoto($event, '')" name="imagem" accept="image/*" required>
                <div class="has-text-danger" v-html="formValidate.imagem"></div>

			</div>
		</div>
	</div>
	<div slot="foot">
		<button class="btn btn-dark" @click="adicionaCadastro">Adicionar</button>
	</div>

</modal>


<!--update modal-->

<modal v-if="editarModal" @close="clearAll()">
	<h5 slot="head">Editar Usuário</h5>
	<div slot="body" class="row">
		<div class="col-md-6">
			<div class="form-group">

				<label>Nome</label>
				<input type="text" class="form-control" :class="{'is-invalid': formValidate.nome}" name="nome"
					   v-model="updtCadastro.nome">

				<div class="has-text-danger" v-html="formValidate.nome"></div>
			</div>
			<div class="form-group">

				<label>Sobrenome</label>
				<input type="text" class="form-control" :class="{'is-invalid': formValidate.sobrenome}" name="sobrenome"
					   v-model="updtCadastro.sobrenome">

				<div class="has-text-danger" v-html="formValidate.sobrenome"></div>
			</div>

			<div class="form-group">
				<label for="">Sexo</label><br>
				<select name="sexo" id="sexo" class="form-control" v-model="updtCadastro.sexo">
					<option value="">Selecione</option>
					<option value="M" :selected="updtCadastro.sexo == 'M'">Masculino</option>
					<option value="F" :selected="updtCadastro.sexo == 'F'">Feminino</option>
				</select>
				<div class="has-text-danger" v-html="formValidate.sexo"></div>
			</div>
			<div class="form-group">
				<label>Nascimento</label>
				<input type="date" class="form-control" :class="{'is-invalid': formValidate.nascimento}"
					   name="nascimento" id="nascimento"
					   @change="calculaIdade(updtCadastro.nascimento)"
					   v-model="updtCadastro.nascimento">
				<div class="has-text-danger" v-html="formValidate.nascimento"></div>
				<div>{{ idade }} </div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<label>Email</label>
				<input type="text" class="form-control" :class="{'is-invalid': formValidate.email}" name="email"
					   v-model="updtCadastro.email">
				<div class="has-text-danger" v-html="formValidate.email"></div>
			</div>
			<div class="form-group">
				<label>Fone</label>
				<input type="text" class="form-control" :class="{'is-invalid': formValidate.fone}" name="fone"
					   v-model="updtCadastro.fone" v-mask="phoneMaskUpdate">
				<div class="has-text-danger" v-html="formValidate.fone"></div>
			</div>
			<div class="form-group">
				<label>Foto</label> <br>

<!--				<label>Foto</label><br>-->
<!--				<img v-if="previewFoto" :src="previewFoto" width='150' height="150">-->
<!--				<div v-else>-</div>-->
<!--				<input type="file" @change="mudaFoto" name="imagem" accept="image/*" required>-->


				<img v-if="updtCadastro.foto" :src="imgFoto(updtCadastro.foto)" id="previewFoto"  width='150' height="150">
				<div v-else>-</div>
                <input type="file" @change="mudaFoto($event, 'atualiza')" name="imagem" accept="image/*" required>
                <div class="has-text-danger" v-html="formValidate.imagem"></div>
            </div>
		</div>
	</div>
	<div slot="foot">
		<button class="btn btn-dark" @click="atualizaCadastro">Atualizar</button>
	</div>
</modal>


<!--delete modal-->
<modal v-if="apagarModal" @close="clearAll()">
	<h5 slot="head">Apagar</h5>
	<div slot="body" class="text-center">Deseja apagar este registro?</div>
	<div slot="foot">
		<button class="btn btn-dark" @click="apagarModal = false; removeCadastro()">Apagar</button>
		<button class="btn" @click="apagarModal = false">Cancelar</button>
	</div>
</modal>
