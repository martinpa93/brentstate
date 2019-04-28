<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0">
    <title>Fin de contrato $contract->property_id</title>
</head>
<body>
    <p>Se ha detectado que el contrato con referencia catastral finalizará el próximo mes.</p>
    <ul>
        <li>Referencia catastral del inmueble: {{ $contract->property_id }}</li>
        <li>Dirección del inmueble: {{ $property->address }}</li>
        <li>Tipo de inmueble: {{ $property->type }}</li>
        <li>DNI inquilino: {{ $contract->renter_id }}</li>
        <li>Nombre y Apellidos del inquilino: {{ $renter->name }} {{ $renter->surname }}</li>
        <li>Dirección del inquilino: {{ $renter->address }} {{ $renter->surname }}</li>
        <li>Teléfono del inquilino: {{ $renter->phone }}</li>
        <li>Fecha comienzo del contrato: {{ $contract->dstart }}</li>
        <li>Fecha finalización del contrato: {{ $contract->dend }}</li>
        <li>IVA: {{ $contract->iva }}</li>
        <li>Gastos de agua: {{ $contract->watertax }}</li>
        <li>Gastos de gas: {{ $contract->gastax }}</li>
        <li>Gastos de electricidad: {{ $contract->electricitytax }}</li>
        <li>Gastos de comunidad: {{ $contract->communitytax }}</li>
    </ul>
</body>
</html>