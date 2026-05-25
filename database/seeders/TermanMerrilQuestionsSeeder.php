<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TermanMerrilQuestionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        $questions = [
            // SERIE I (Competence 56)
            [13, 56, 1, 'LA GASOLINA SE EXTRAE DE:', null, 2, 1],
            [13, 56, 2, 'UNA TONELADA TIENE:', null, 2, 1],
            [13, 56, 3, 'LA MAYORÍA DE NUESTRAS EXPORTACIONES SALEN POR:', null, 2, 1],
            [13, 56, 4, 'EL NERVIO ÓPTICO SIRVE PARA:', null, 2, 1],
            [13, 56, 5, 'EL CAFÉ ES UNA ESPECIE DE:', null, 2, 1],
            [13, 56, 6, 'EL JAMON ES CARNE DE:', null, 2, 1],
            [13, 56, 7, 'LA LARINGE ESTA EN:', null, 2, 1],
            [13, 56, 8, 'LA GUILLOTINA CAUSA:', null, 2, 1],
            [13, 56, 9, 'LA GRUA SE USA PARA:', null, 2, 1],
            [13, 56, 10, 'UNA FIGURA DE SEIS LADOS SE LLAMA:', null, 2, 1],
            [13, 56, 11, 'EL KILOWAT MIDE:', null, 2, 1],
            [13, 56, 12, 'LA PAUSA SE UTILIZA EN:', null, 2, 1],
            [13, 56, 13, 'LAS ESMERALDAS SON:', null, 2, 1],
            [13, 56, 14, 'EL METRO ES APROXIMADAMENTE IGUAL A:', null, 2, 1],
            [13, 56, 15, 'LAS ESPONJAS SE OBTIENEN DE:', null, 2, 1],
            [13, 56, 16, 'FRAUDE ES UN TÉRMINO UTILIZADO EN:', null, 2, 1],

            // SERIE II (Competence 57)
            [13, 57, 1, 'SI LA TIERRA ESTUVIERA MAS CERCA DEL SOL:', null, 2, 1],
            [13, 57, 2, 'LOS RAYOS DE UNA RUEDA ESTÁN FRECUENTEMENTE HECHOS DE NOGAL POR QUE:', null, 2, 1],
            [13, 57, 3, 'UN TREN SE DETIENE CON MAS DIFICULTAD QUE UN AUTOMOVIL. POR QUE:', null, 2, 1],
            [13, 57, 4, 'EL DICHO "A GOLPECITOS SE DERRIBA UN ROBLE" QUIERE DECIR:', null, 2, 1],
            [13, 57, 5, 'EL DICHO "UNA OLLA VIGILADA NUNCA HIERVE" QUIERE DECIR:', null, 2, 1],
            [13, 57, 6, 'EL DICHO "SIEMBRA PASTO MIENTRAS HAYA SOL" QUIERE DECIR:', null, 2, 1],
            [13, 57, 7, 'EL DICHO "ZAPATERO A TUS ZAPATOS" QUIERE DECIR:', null, 2, 1],
            [13, 57, 8, 'EL DICHO "LA CUÑA PARA QUE APRIETE TIENE QUE SER DEL MISMO PALO" QUIERE DECIR:', null, 2, 1],
            [13, 57, 9, 'UN ACORAZADO DE ACERO FLOTAN PORQUE:', null, 2, 1],
            [13, 57, 10, 'LAS PLUMAS DE LAS ALAS AYUDAN AL PAJARO A VOLAR PORQUE:', null, 2, 1],
            [13, 57, 11, 'EL DICHO "UNA GOLONDRINA NO HACE VERANO" QUIERE DECIR:', null, 2, 1],

            // SERIE III (Competence 58)
            [13, 58, 1, 'SALADO – DULCE', null, 2, 1],
            [13, 58, 2, 'ALEGRE – REGOCIJARSE', null, 2, 1],
            [13, 58, 3, 'MAYOR – MENOR', null, 2, 1],
            [13, 58, 4, 'SENTARSE – PARARSE', null, 2, 1],
            [13, 58, 5, 'DESPERDICIAR – APROVECHAR', null, 2, 1],
            [13, 58, 6, 'CONOCER – NEGAR', null, 2, 1],
            [13, 58, 7, 'TONICO – ESTIMULAR', null, 2, 1],
            [13, 58, 8, 'REBAJAR – DENIGRAR', null, 2, 1],
            [13, 58, 9, 'PROHIBIR – PERMITIR', null, 2, 1],
            [13, 58, 10, 'OSADO – AUDAZ', null, 2, 1],
            [13, 58, 11, 'ARREBATADO – PRUDENTE', null, 2, 1],
            [13, 58, 12, 'OBTUSO – AGUDO', null, 2, 1],
            [13, 58, 13, 'INEPTO – EXPERTO', null, 2, 1],
            [13, 58, 14, 'ESQUIVAR – REHUIR', null, 2, 1],
            [13, 58, 15, 'REVELARSE – SOMETERSE', null, 2, 1],
            [13, 58, 16, 'MONOTONIA – VARIEDAD', null, 2, 1],
            [13, 58, 17, 'CONFORTAR – CONSOLAR', null, 2, 1],
            [13, 58, 18, 'EXPELER – RETENER', null, 2, 1],
            [13, 58, 19, 'DOCIL – SUMISO', null, 2, 1],
            [13, 58, 20, 'TRANSITORIO – PERMANENTE', null, 2, 1],
            [13, 58, 21, 'SEGURIDAD – RIESGO', null, 2, 1],
            [13, 58, 22, 'APROVECHAR – OBJETAR', null, 2, 1],
            [13, 58, 23, 'EXPELER – ARROJAR', null, 2, 1],
            [13, 58, 24, 'ENGAÑO – IMPOSTURA', null, 2, 1],
            [13, 58, 25, 'MITIGAR – APACIGUAR', null, 2, 1],
            [13, 58, 26, 'INICIATIVA – APLICAR', null, 2, 1],
            [13, 58, 27, 'REVERENCIA – VENERACION', null, 2, 1],
            [13, 58, 28, 'SOBRIEDAD – FRUGALIDAD', null, 2, 1],
            [13, 58, 29, 'AUMENTAR – MENGUAR', null, 2, 1],
            [13, 58, 30, 'INCITAR – INSTIGAR', null, 2, 1],

            // SERIE IV (Competence 59)
            [13, 59, 1, 'UN CÍRCULO TIENE SIEMPRE:', null, 2, 1],
            [13, 59, 2, 'UN PÁJARO TIENE SIEMPRE:', null, 2, 1],
            [13, 59, 3, 'LA MÚSICA TIENE SIEMPRE:', null, 2, 1],
            [13, 59, 4, 'UN BANQUETE TIENE SIEMPRE:', null, 2, 1],
            [13, 59, 5, 'UN CABALLO TIENE SIEMPRE:', null, 2, 1],
            [13, 59, 6, 'UN JUEGO TIENE SIEMPRE:', null, 2, 1],
            [13, 59, 7, 'UN OBJETO TIENE SIEMPRE:', null, 2, 1],
            [13, 59, 8, 'UNA CONVERSACIÓN TIENE SIEMPRE:', null, 2, 1],
            [13, 59, 9, 'UNA DEUDA IMPLICA SIEMPRE:', null, 2, 1],
            [13, 59, 10, 'UN CIUDADANO TIENE SIEMPRE:', null, 2, 1],
            [13, 59, 11, 'UN MUSEO TIENE SIEMPRE:', null, 2, 1],
            [13, 59, 12, 'UN COMPROMISO IMPLICA SIEMPRE:', null, 2, 1],
            [13, 59, 13, 'UN BOSQUE TIENE SIEMPRE:', null, 2, 1],
            [13, 59, 14, 'LOS OBSTÁCULOS TIENEN SIEMPRE:', null, 2, 1],
            [13, 59, 15, 'EL ABORRECIMIENTO TIENE SIEMPRE:', null, 2, 1],
            [13, 59, 16, 'UNA REVISTA TIENE SIEMPRE:', null, 2, 1],
            [13, 59, 17, 'LA CONTROVERSIA IMPLICA SIEMPRE:', null, 2, 1],
            [13, 59, 18, 'UN BARCO TIENE SIEMPRE:', null, 2, 1],

            // SERIE V (Competence 60)
            [13, 60, 1, 'A 2 POR 5 PESOS. ¿CUÁNTOS LÁPICES PUEDEN COMPRAR CON 50 PESOS?', null, 2, 1],
            [13, 60, 2, '¿CUÁNTAS HORAS TARDARÁ UN AUTOMOVIL EN RECORRER 660 KILÓMETROS A LA VELOCIDAD DE 60 KILÓMETROS POR HORA?', null, 2, 1],
            [13, 60, 3, 'SI UN HOMBRE GANA $200.00 DIARIOS Y GASTA $140.00 ¿CUÁNTOS DÍAS TARDARÁ EN AHORRAR $3,000.00?', null, 2, 1],
            [13, 60, 4, 'SI DOS PASTELES CUESTAN $600.00. ¿CUÁNTOS PESOS CUESTA LA SEXTA PARTE DEL PASTEL?', null, 2, 1],
            [13, 60, 5, '¿CUÁNTAS VECES MAS ES 2 X 3 X 4 X 6 QUE 3 X 4?', null, 2, 1],
            [13, 60, 6, '¿CUÁNTO ES EL 15 POR CIENTO DE $120.00?', null, 2, 1],
            [13, 60, 7, 'EL 4 POR CIENTO DE $1,000.00 ES IGUAL AL 8 POR CIENTO ¿DE QUÉ CANTIDAD?', null, 2, 1],
            [13, 60, 8, 'LA CAPACIDAD DE UN REFRIGERADOR RECTANGULAR ES DE 48 METROS CUBICOS SI TIENE SEIS METROS DE LARGO POR CUATRO DE ANCHO ¿CUÁL ES SU ALTURA?', null, 2, 1],
            [13, 60, 9, 'SI 7 HOMBRES HACEN UN POZO DE 40 METROS EN 2 DÍAS ¿CUÁNTOS SE NECESITAN PARA HACERLO EN MEDIO DÍA?', null, 2, 1],
            [13, 60, 10, '(A) TIENE $180.00, (B) TIENE 2/3 DE LO QUE TIENE (A) Y (C) TIENE ½ DE LO QUE TIENE (B). ¿CUÁNTO TIENEN TODOS JUNTOS?', null, 2, 1],
            [13, 60, 11, 'SI UN HOMBRE CORRE 100 METROS EN 10 SEGUNDOS, ¿CUÁNTOS METROS RECORRERA COMO PROMEDIO EN 1/5 DE SEGUNDO?', null, 2, 1],
            [13, 60, 12, 'UN HOMBRE GASTA ¼ DE SU SUELDO EN CASA Y ALIMENTO, 4/8 EN OTROS GASTOS. ¿QUÉ TANTO POR CIENTO DE SU SUELDO AHORRA?', null, 2, 1],

            // SERIE VI (Competence 61)
            [13, 61, 1, 'LA HIGIENE ES ESENCIAL PARA LA SALUD', null, 2, 1],
            [13, 61, 2, 'LOS TAQUIGRAFOS USAN MICROSCOPIO', null, 2, 1],
            [13, 61, 3, 'LOS TIRANOS SON JUSTOS CON SUS INFERIORES', null, 2, 1],
            [13, 61, 4, 'LAS PERSONAS DESAMPARADAS ESTÁN SUJETAS CON FRECUENCIA A LA CARIDAD', null, 2, 1],
            [13, 61, 5, 'LAS PERSONAS VENERABLES SON POR LO COMUN RESPETADAS', null, 2, 1],
            [13, 61, 6, 'ES EL ESCARBUTO UN MEDICAMENTO', null, 2, 1],
            [13, 61, 7, 'ES LA AMONESTACIÓN UNA CLASE DE INSTRUMENTO MUSICAL', null, 2, 1],
            [13, 61, 8, 'SON LOS COLORES OPACOS PREFERIDOS PARA LAS BANDERAS NACIONALES', null, 2, 1],
            [13, 61, 9, 'LAS COSAS MISTERIOSAS SON A VECES PAVOROSAS', null, 2, 1],
            [13, 61, 10, 'PERSONAS CONSCIENTES COMETEN ALGUNA VEZ ERRORES', null, 2, 1],
            [13, 61, 11, 'SON CARNIVOROS LOS CARNEROS', null, 2, 1],
            [13, 61, 12, 'SE DAN ASIGNATURAS A LOS CABALLOS', null, 2, 1],
            [13, 61, 13, 'LAS CARTAS ANÓNIMAS LLEVAN ALGUNA FIRMA DE QUIEN LAS ESCRIBE', null, 2, 1],
            [13, 61, 14, 'SON DISCONTINUOS LOS SONIDOS INTERMITENTES', null, 2, 1],
            [13, 61, 15, 'LAS ENFERMEDADES ESTIMULAN EL BUEN JUICIO', null, 2, 1],
            [13, 61, 16, 'SON SIEMPRE PERVERSOS LOS HECHOS PREMEDITADOS', null, 2, 1],
            [13, 61, 17, 'EL CONTACTO SOCIAL TIENDE A REDUCIR LA TIMIDEZ', null, 2, 1],
            [13, 61, 18, 'SON ENFERMAS LAS PERSONAS QUE TIENEN MAL CARÁCTER', null, 2, 1],
            [13, 61, 19, 'SE CARACTERIZAN GENERALMENTE EL RENCOR POR LA PERSISTENCIA', null, 2, 1],
            [13, 61, 20, 'METICULOSO QUIERE DECIR LO MISMO QUE CUIDADOSO', null, 2, 1],

            // SERIE VII (Competence 62)
            [13, 62, 1, 'ABRIGO ES A USAR COMO PAN ES A:', null, 2, 1],
            [13, 62, 2, 'SEMANA ES A MES COMO MES ES A:', null, 2, 1],
            [13, 62, 3, 'LEON ES A ANIMAL COMO ROSA ES A:', null, 2, 1],
            [13, 62, 4, 'LIBERTAD ES A INDEPENDENCIA COMO CAUTIVERIO ES A:', null, 2, 1],
            [13, 62, 5, 'DECIR ES A DIJO COMO ESTAR ES A:', null, 2, 1],
            [13, 62, 6, 'LUNES ES A MARTES COMO VIERNES ES A:', null, 2, 1],
            [13, 62, 7, 'PLOMO ES A PESADO COMO CORCHO ES A:', null, 2, 1],
            [13, 62, 8, 'ÉXITO ES A ALEGRÍA COMO FRACASO ES A:', null, 2, 1],
            [13, 62, 9, 'GATO ES A TIGRE COMO PERRO ES A:', null, 2, 1],
            [13, 62, 10, 'CUATRO ES A DIEZ Y SEIS COMO CINCO ES A:', null, 2, 1],
            [13, 62, 11, 'LLORAR ES A REIR COMO TRISTE ES A:', null, 2, 1],
            [13, 62, 12, 'VENENO ES A MUERTE COMO ALIMENTO ES A:', null, 2, 1],
            [13, 62, 13, '1 ES A 3 COMO 9 ES A:', null, 2, 1],
            [13, 62, 14, 'ALIMENTO ES A HAMBRE COMO AGUA ES A:', null, 2, 1],
            [13, 62, 15, 'AQUÍ ES ALLI COMO ESTE ES A:', null, 2, 1],
            [13, 62, 16, 'TIGRE ES A PELO COMO TRUCHA ES A:', null, 2, 1],
            [13, 62, 17, 'PERVERTIDO ES A DEPRAVADO COMO INCORRUPTO ES A:', null, 2, 1],
            [13, 62, 18, '(B) ES A (D) COMO SEGUNDO ES A:', null, 2, 1],
            [13, 62, 19, 'ESTADO ES A GOBERNADOR COMO EJÉRCITO ES A:', null, 2, 1],
            [13, 62, 20, 'SUJETO ES A PREDICADO COMO NOMBRE ES A:', null, 2, 1],

            // SERIE VIII (Competence 63)
            [13, 63, 1, 'CON CRECEN LOS NIÑOS EDAD LA.', null, 2, 1],
            [13, 63, 2, 'BUENA MAR BEBER EL PARA AGUA DE ES.', null, 2, 1],
            [13, 63, 3, 'LO ES PAZ LA GUERRA OPUESTO LA A.', null, 2, 1],
            [13, 63, 4, 'CABALLOS AUTOMOVIL UN QUE CAMINAN LOS DESPACIO MAS.', null, 2, 1],
            [13, 63, 5, 'CONSEJO A VECES ES BUEN SEGUIR UN DIFICIL.', null, 2, 1],
            [13, 63, 6, 'CUATROSCIENTAS TODOS PAGINAS CONTIENEN LIBROS LOS.', null, 2, 1],
            [13, 63, 7, 'CRECEN LAS QUE FRESAS EL MAS ROBLE.', null, 2, 1],
            [13, 63, 8, 'VERDADERA COMPRADA UNA NO PUEDE AMISTAD SER.', null, 2, 1],
            [13, 63, 9, 'ENVIDIA LA PERJUDICIALES GULA SON Y LA.', null, 2, 1],
            [13, 63, 10, 'NUNCA ACCIONES PREMIADAS LAS DEBEN BUENAS SER.', null, 2, 1],
            [13, 63, 11, 'EXTERIORES ENGAÑAN NUNCA APARIENCIAS LAS NOS.', null, 2, 1],
            [13, 63, 12, 'NUNCA ES HOMBRE LAS QUE ACCIONES DEMUESTRAN UN LO.', null, 2, 1],
            [13, 63, 13, 'CIERTA SIEMPRE MUERTE DE CAUSAN CLASE ENFERMEDADES.', null, 2, 1],
            [13, 63, 14, 'ODIO INDESEABLES AVERSION SENTIMIENTOS EL SON Y LA.', null, 2, 1],
            [13, 63, 15, 'FRECUENTEMENTE POR JUZGAR PODEMOS ACCIONES HOMBRES NOSOTROS SUS A LOS.', null, 2, 1],
            [13, 63, 16, 'UNA SON SABANA SARAPES TAN NUNCA LOS CALIENTES COMO.', null, 2, 1],
            [13, 63, 17, 'NUNCA QUE DESCUIDADOS LOS TROPIEZAN SON.', null, 2, 1],

            // SERIE IX (Competence 64)
            [13, 64, 1, '1', null, 2, 1],
            [13, 64, 2, '2', null, 2, 1],
            [13, 64, 3, '3', null, 2, 1],
            [13, 64, 4, '4', null, 2, 1],
            [13, 64, 5, '5', null, 2, 1],
            [13, 64, 6, '6', null, 2, 1],
            [13, 64, 7, '7', null, 2, 1],
            [13, 64, 8, '8', null, 2, 1],
            [13, 64, 9, '9', null, 2, 1],
            [13, 64, 10, '10', null, 2, 1],
            [13, 64, 11, '11', null, 2, 1],
            [13, 64, 12, '12', null, 2, 1],
            [13, 64, 13, '13', null, 2, 1],
            [13, 64, 14, '14', null, 2, 1],
            [13, 64, 15, '15', null, 2, 1],
            [13, 64, 16, '16', null, 2, 1],
            [13, 64, 17, '17', null, 2, 1],
            [13, 64, 18, '18', null, 2, 1],

            // SERIE X (Competence 65)
            [13, 65, 1, 'RENGLON 8 7 6 5 4 3', null, 2, 1],
            [13, 65, 2, 'RENGLON 3 8 13 18 23 28', null, 2, 1],
            [13, 65, 3, 'RENGLON 1 2 4 8 16 32', null, 2, 1],
            [13, 65, 4, 'RENGLON 8 8 6 6 4 4', null, 2, 1],
            [13, 65, 5, 'RENGLON 11 ¾, 12, 12 ¼, 12, 12 ½, 12 ¾', null, 2, 1],
            [13, 65, 6, 'RENGLON 8 9 12 13 16 17', null, 2, 1],
            [13, 65, 7, 'RENGLON 16 8 3 2 1 ½', null, 2, 1],
            [13, 65, 8, 'RENGLON 31.3 40.3 49.3 58.3 67,3 76.3', null, 2, 1],
            [13, 65, 9, 'RENGLON 3 5 4 6 5 7', null, 2, 1],
            [13, 65, 10, 'RENGLON 7 11 15 16 20 24 25 29', null, 2, 1],
            [13, 65, 11, 'RENGLON 1/25, 1/5, 1, 5', null, 2, 1],
        ];

        $dataToInsert = array_map(function ($q) use ($now) {
            return [
                'evaluations_type_id' => $q[0],
                'competence_id'       => $q[1],
                'order'               => $q[2],
                'question'            => $q[3],
                'comment'             => $q[4],
                'answer_type_id'      => $q[5],
                'status'              => $q[6],
                'created_at'          => $now,
                'updated_at'          => $now,
            ];
        }, $questions);

        // Usamos chunks o inserción masiva directa para mayor eficiencia
        foreach (array_chunk($dataToInsert, 50) as $chunk) {
            DB::table('questions')->insert($chunk);
        }
    }
}
