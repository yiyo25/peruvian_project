<div class="row">
    <div class="col-md-12 ">
        <form id="manifiesto-form" class="form-horizontal" >

            <div class="row">
                <div class="col-lg-6">
                    <label for="nroTicket">Nro Ticket</label>
                    <input type="number" class="form-control" id="nroTicket" placeholder="" />
                    <small id="emailHelp" class="form-text text-muted">13 digitos</small>
                </div>
                <div class="col-lg-6">
                    <label for="Apellido">Apellido</label>
                    <input type="text" class="form-control"  id="Apellido" style="text-transform: uppercase;"/>
                    <small id="emailHelp" class="form-text text-muted">Solo letras</small>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <label for="Nombre">Nombre</label>
                    <input type="text" class="form-control" id="Nombre" style="text-transform: uppercase;"/>
                    <small id="emailHelp" class="form-text text-muted">Solo letras</small>
                </div>
                <div class="col-lg-6">
                    <label for="Pax">Pax</label>
                    <input type="text" class="form-control" id="Pax"  style="text-transform: uppercase;"/>
                    <small id="emailHelp" class="form-text text-muted">Solo 1 letra</small>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <label for="Foid">Foid</label>
                    <input type="text" class="form-control" id="Foid"  style="text-transform: uppercase;"/>
                    <small id="emailHelp" class="form-text text-muted">Solo 2 letras y el resto caracteres</small>
                </div>
                <div class="col-lg-6">
                    <label for="Destino">Destino</label>
                    <input type="text" class="form-control" id="Destino" style="text-transform: uppercase;"/>
                    <small id="emailHelp" class="form-text text-muted">Solo 3 letras</small>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <label for="Clase">Clase</label>
                    <input type="text" class="form-control" id="Clase"  style="text-transform: uppercase;" />
                    <small id="emailHelp" class="form-text text-muted">Solo 1 letras</small>
                </div>
                <div class="col-lg-6">
                    <label for="Cupon">Cupon</label>
                    <input type="number" class="form-control" id="Cupon" />
                    <small id="emailHelp" class="form-text text-muted">Solo 1 o 2</small>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <label for="Ref">Ref</label>
                    <input type="number" class="form-control" id="Ref" />
                    <small id="emailHelp" class="form-text text-muted">Solo 3 digitos</small>
                </div>
                <div class="col-lg-6">
                    <label for="Asiento">Asiento</label>
                    <input type="text" class="form-control" id="Asiento"/>
                    <small id="emailHelp" class="form-text text-muted">Solo 4 caracteres</small>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <label for="NroDoc">Nro Doc</label>
                    <input type="text" class="form-control" id="NroDoc" />

                </div>
                <div class="col-lg-6">
                    <label for="Nac">Nac</label>
                    <input type="text" class="form-control" id="Nac"/>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-lg-offset-2 col-lg-10">
                    <div class="buttonrigth">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                        {if $typeForm eq "create"}
                        <button type="button" class="btn btn-success" id="btnSavePasajero">Guardar</button>
                        {/if}
                        {if $typeForm eq "edit"}
                            <button type="button" class="btn btn-success" id="btnEditPasajero">Actualizar</button>
                        {/if}
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<style>

    .buttonrigth{
        text-align: right;
        padding: 15px;
    }
    label.error{
        color: red;
        font-size: 12px;
    }


</style>
