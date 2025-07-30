<?= $this->extend('layouts/dashboard')?>

<?= $this->section('content')?>
 <div class="container mt-5 " >
    <div class="card shadow-sm border-0 mx-auto" style="width: 600px;">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0"><?= $title ?></h4>
        </div>
        <div class="card-body">
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?= session()->getFlashdata('success') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                </div>
            <?php endif; ?>
            <?php if (!empty(validation_errors())): ?>
                <div class="alert alert-danger"><?= validation_list_errors() ?></div>
            <?php endif; ?>

            <form action="/items" method="POST" novalidate>
                <div class="mb-3">
                    <label for="name" class="form-label">Nombre</label>
                    <input type="text" name="name" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="type" class="form-label">Tipo</label>
                    <select name="type" class="form-select" onchange="activateStock(this, event)">
                        <option value="">-- Seleccione el tipo --</option>
                        <option value="product">Producto</option>
                        <option value="service">Servicio</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="category_id" class="form-label">Categoría</label>
                    <select name="category_id" class="form-select" onchange="activatePrice(this, event)">
                        <option value="">-- Seleccione una categoría --</option>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?= $category->id ?>">
                                <?= $category->displayType()." | ".$category->name ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="cost" class="form-label">Costo</label>
                    <input type="number" name="cost" class="form-control" step="0.01" min="0" placeholder="0.50">
                </div>
                <div class="mb-3">
                    <label for="selling_price" class="form-label">Precio de Venta</label>
                    <input type="number" name="selling_price" class="form-control" step="0.01" min="0" placeholder="0.75">
                </div>
                <div class="mb-3">
                    <label for="stock" class="form-label">Cantidad</label>
                    <input type="number" name="stock" class="form-control" step="1" min="1" value="1">
                </div>
                <div class="mb-3">
                    <label for="min_stock" class="form-label">Cantidad Mínima (para alertar)</label>
                    <input type="number" name="min_stock" class="form-control" step="1" min="1" value="1">
                </div>
                <div class="mb-3">
                    <label for="measure_unit" class="form-label">Unidad de Medida</label>
                    <input type="text" name="measure_unit" class="form-control" placeholder="unidad, kg, lb, etc" value="unidad">
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-success">Registrar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
function activateStock (element, event) {
    const inputStock = document.querySelector("input[name='stock']");
    const inputMinStock = document.querySelector("input[name='min_stock']");
    const inputMeasureUnit = document.querySelector("input[name='measure_unit']");
    const inputs = [inputStock, inputMinStock, inputMeasureUnit];

    for (const input of inputs) {
        input.disabled = event.target.value === "product" ? false : true;
        input.value = event.target.value === "product" ?
        input.name !== 'measure_unit' ? 1 : 'unidad' : null;
    }
    
}
function activatePrice (element, event) {
    const selectedOption = event.target.selectedOptions[0].text;
    const itemType = selectedOption.substring(0, selectedOption.lastIndexOf("|")).trim();
    const inputSellingPrice = document.querySelector("input[name='selling_price']");

    inputSellingPrice.disabled = itemType === "Ingreso" ? false : true;
    inputSellingPrice.placeholder = itemType === "Ingreso" ? 0.75 : "";
}
</script>
<?= $this->endSection()?>