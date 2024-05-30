<?php
$this->load->helper('language');
$this->lang->load('custom_lang', 'portuguese-brazilian');
?>
<ul class="nav justify-content-center bg-primary text-light">
	<li class="nav-item">
		<a class="nav-link text-white h4" href="<?php echo base_url(); ?>cadastro">SMB Store - Sistema de Cadastro em
			Codeigniter com VueJS</a>
	</li>
</ul>
<div id="app">
	<div class="container-fluid">
		<div class="row">
			<transition
				enter-active-class="animated fadeInLeft"
				leave-active-class="animated fadeOutRight">
				<div class="notification is-warning text-center px-5 top-middle" v-if="mensagemSucesso"
					 @click="mensagemSucesso = false"><h4>{{mensagemSucesso}}</h4>
				</div>
			</transition>


			<div class="col-md-12">
				<div class="row">
					<div class="col-md-4 my-3">
						<button class="btn btn-default btn-block"
								@click="adicionarModal= true; idade = ''"><?php print lang('Add') ?></button>
					</div>
					<div class="col-md-3">
						<br>
						<input placeholder="<?php print lang('Search by name') ?>" type="search" class="form-control"
							   v-model="search.text" @keyup="searchCadastro('nome')" name="search">
					</div>
					<div class="col-md-3">
						<br>
						<input placeholder="Buscar por email" type="search" class="form-control"
							   v-model="search.email" @keyup="searchCadastro('email')" name="search">
					</div>
				</div>
				<table class="table is-bordered is-hoverable">
					<thead class="text-white bg-info">
					<tr>
						<th class="text-center text-white"><a href="#" @click="buscaTodos('id')">ID</a></th>
						<th class="text-center text-white">Foto</th>
						<th class="text-white"><a href="#" @click="buscaTodos('nome')">Nome</a></th>
						<th class="text-white"><a href="#" @click="buscaTodos('sobrenome')">Sobrenome</a></th>
						<th class="text-white"><a href="#" @click="buscaTodos('email')">Email</a></th>
						<th class="text-white"><a href="#" @click="buscaTodos('fone')">Fone</a></th>
						<th class="text-white"><a href="#" @click="buscaTodos('nascimento')">Nascimento</a></th>
						<th class="text-center text-white">Sexo</th>
						<th colspan="2" class="text-center text-white"></th>
					</tr>
					</thead>
					<tbody class="table-light">
					<tr v-for="user in users" class="table-default">
						<td class="text-center">{{user.id}}</td>
						<td class="text-center">
							<img v-if="user.foto" :src="imgFoto(user.foto)"  width='50' height="50">
							<span v-else>-</span>
						</td>
						<td>{{user.nome}}</td>
						<td>{{user.sobrenome}}</td>
						<td>{{user.email}}</td>
						<td>{{user.fone}}</td>
						<td v-if="user.nascimento == '' || user.nascimento == '0000-00-00'">-</td>
						<td v-else>{{moment(user.nascimento,'YYYY-MM-DD').format("DD/MM/YYYY") }}</td>
						<td class="text-center">
							<h4 v-if="user.sexo=='F'" class="pink-text mb-0"><i class="fa fa-venus"></i></h4>
							<h4 v-if="user.sexo=='M'" class="text-info mb-0"><i class="fa fa-mars"></i></h4>
						</td>
						<td class="text-center">
							<button class="btn btn-info fa fa-edit"
									@click="editarModal = true; selectCadastro(user)"></button>
						</td>
						<td class="text-center">
							<button class="btn btn-danger fa fa-trash"
									@click="apagarModal = true; selectCadastro(user)"></button>
						</td>
					</tr>
					<tr v-if="emptyResult">
						<td colspan="9" rowspan="4" class="text-center h5">Sem registros</td>
					</tr>
					</tbody>

				</table>

			</div>

		</div>
		<pagination
			:current_page="currentPage"
			:row_count_page="rowCountPage"
			@page-update="pageUpdate"
			:total_users="totalCadastros"
			:page_range="pageRange"
		>
		</pagination>
		<p class="footer">Carragemento em <strong>{elapsed_time}</strong> s. <?php echo  (ENVIRONMENT === 'development') ?  'CodeIgniter Version <strong>' . CI_VERSION . '</strong>' : '' ?></p>
	</div>
	<?php include 'modal.php'; ?>


</div>

