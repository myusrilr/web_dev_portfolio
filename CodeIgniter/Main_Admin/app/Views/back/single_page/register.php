<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Registrasi Ulang</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo base_url() ?>singlepage/fonts/material-design-iconic-font/css/material-design-iconic-font.min.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>singlepage/css/style.css">
    <link rel="icon" type="image/x-icon" href="<?php echo base_url(); ?>back/assets/img/leap.png">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests" />

    <style>
        .back {
            background: url('<?php echo base_url() ?>singlepage/images/bgcalon.jpg') no-repeat center center fixed;
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: 100% 100%;
        }
    </style>
</head>

<body>
    <div class="wrapper back">
        <div class="inner">
            <form action="<?php echo base_url() ?>registrasiulang/proses" method="post">
                <h3>Registrasi Ulang</h3>
                <input type="hidden" id="idsiswa" name="idsiswa" value="<?php echo $siswa->idsiswa; ?>">
                <h2 style="margin-top: -30px;">1. DATA SISWA</h2>
                <hr>
                <div class="form-group">
                    <div class="form-wrapper">
                        <label>Nama Lengkap Siswa<span style="color: red;">*</span></label>
                        <div class="form-holder">
                            <input id="nama_lengkap" name="nama_lengkap" type="text" oninput="this.value = this.value.toUpperCase();" value="<?php echo strtoupper($siswa->nama_lengkap); ?>" class="form-control" autocomplete="off">
                        </div>
                        <small class="invalid-feedback">Sesuai AKTA KELAHIRAN Siswa</small>
                    </div>
                    <div class="form-wrapper">
                        <label>Tempat Lahir<span style="color: red;">*</span></label>
                        <div class="form-holder">
                            <input id="tmp_lahir" name="tmp_lahir" type="text" class="form-control" value="<?php echo $siswa->tmp_lahir; ?>" autocomplete="off">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-wrapper">
                        <label>Nama Panggilan Siswa<span style="color: red;">*</span></label>
                        <div class="form-holder">
                            <input id="panggilan" name="panggilan" type="text" oninput="this.value = this.value.toUpperCase();" class="form-control" value="<?php echo strtoupper($siswa->panggilan); ?>" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-wrapper">
                        <label>Tanggal Lahir<span style="color: red;">*</span></label>
                        <div class="form-holder">
                            <input id="tgl_lahir" name="tgl_lahir" type="date" class="form-control" value="<?php echo date('Y-m-d', strtotime($siswa->tgl_lahir)); ?>" autocomplete="off">
                        </div>
                    </div>                    
                </div>
                <div class="form-group">
                    <div class="form-wrapper">
                        <label>NISN (Nomer Induk Siswa Nasional)</label>
                        <div class="form-holder">
                            <input id="nisn" name="nisn"  onkeypress="return hanyaAngka(event,false);" type="text" class="form-control" value="<?php echo $siswa->nisn; ?>" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-wrapper">
                        <label>Jenis kelamin<span style="color: red;">*</span></label>
                        <div class="form-holder select">
                            <select id="jkel" name="jkel" class="form-control">
                                <option value="-" disabled>- Pilih Jenis Kelamin -</option>
                                <option value="Perempuan" <?php if($siswa->jkel == "Perempuan"){ echo 'selected'; }?>>Perempuan</option>
                                <option value="Laki-laki" <?php if($siswa->jkel == "Laki-laki"){ echo 'selected'; }?>>Laki-laki</option>
                            </select>
                        </div>
                    </div>
                </div>    
                <div class="form-group">
                    <div class="form-wrapper">
                        <label>NIK (siswa)<span style="color: red;">*</span></label>
                        <div class="form-holder">
                            <input id="nik" name="nik"  onkeypress="return hanyaAngka(event,false);" type="text" class="form-control" value="<?php echo $siswa->nik; ?>"autocomplete="off">
                        </div>
                    </div>
                    <div class="form-wrapper">
                        <label>Kewarganegaraan<span style="color: red;">*</span></label>
                        <div class="form-holder select">
                            <select id="kewarganegaraan" name="kewarganegaraan" class="form-control">
                                <option value="Indonesia" <?php echo ($siswa->kewarganegaraan == "Indonesia") ? 'selected' : ''; ?>>Indonesia</option>
                                <option value="Afghanistan" <?php echo ($siswa->kewarganegaraan == "Afghanistan") ? 'selected' : ''; ?>>Afghanistan</option>
                                <option value="Albania" <?php echo ($siswa->kewarganegaraan == "Albania") ? 'selected' : ''; ?>>Albania</option>
                                <option value="Algeria" <?php echo ($siswa->kewarganegaraan == "Algeria") ? 'selected' : ''; ?>>Algeria</option>
                                <option value="American Samoa" <?php echo ($siswa->kewarganegaraan == "American Samoa") ? 'selected' : ''; ?>>American Samoa</option>
                                <option value="Andorra" <?php echo ($siswa->kewarganegaraan == "Andorra") ? 'selected' : ''; ?>>Andorra</option>
                                <option value="Angola" <?php echo ($siswa->kewarganegaraan == "Angola") ? 'selected' : ''; ?>>Angola</option>
                                <option value="Anguilla" <?php echo ($siswa->kewarganegaraan == "Anguilla") ? 'selected' : ''; ?>>Anguilla</option>
                                <option value="Antarctica" <?php echo ($siswa->kewarganegaraan == "Antarctica") ? 'selected' : ''; ?>>Antarctica</option>
                                <option value="Antigua and Barbuda" <?php echo ($siswa->kewarganegaraan == "Antigua and Barbuda") ? 'selected' : ''; ?>>Antigua and Barbuda</option>
                                <option value="Argentina" <?php echo ($siswa->kewarganegaraan == "Argentina") ? 'selected' : ''; ?>>Argentina</option>
                                <option value="Armenia" <?php echo ($siswa->kewarganegaraan == "Armenia") ? 'selected' : ''; ?>>Armenia</option>
                                <option value="Aruba" <?php echo ($siswa->kewarganegaraan == "Aruba") ? 'selected' : ''; ?>>Aruba</option>
                                <option value="Australia" <?php echo ($siswa->kewarganegaraan == "Australia") ? 'selected' : ''; ?>>Australia</option>
                                <option value="Austria" <?php echo ($siswa->kewarganegaraan == "Austria") ? 'selected' : ''; ?>>Austria</option>
                                <option value="Azerbaijan" <?php echo ($siswa->kewarganegaraan == "Azerbaijan") ? 'selected' : ''; ?>>Azerbaijan</option>
                                <option value="Bahamas" <?php echo ($siswa->kewarganegaraan == "Bahamas") ? 'selected' : ''; ?>>Bahamas</option>
                                <option value="Bahrain" <?php echo ($siswa->kewarganegaraan == "Bahrain") ? 'selected' : ''; ?>>Bahrain</option>
                                <option value="Bangladesh" <?php echo ($siswa->kewarganegaraan == "Bangladesh") ? 'selected' : ''; ?>>Bangladesh</option>
                                <option value="Barbados" <?php echo ($siswa->kewarganegaraan == "Barbados") ? 'selected' : ''; ?>>Barbados</option>
                                <option value="Belarus" <?php echo ($siswa->kewarganegaraan == "Belarus") ? 'selected' : ''; ?>>Belarus</option>
                                <option value="Belgium" <?php echo ($siswa->kewarganegaraan == "Belgium") ? 'selected' : ''; ?>>Belgium</option>
                                <option value="Belize" <?php echo ($siswa->kewarganegaraan == "Belize") ? 'selected' : ''; ?>>Belize</option>
                                <option value="Benin" <?php echo ($siswa->kewarganegaraan == "Benin") ? 'selected' : ''; ?>>Benin</option>
                                <option value="Bermuda" <?php echo ($siswa->kewarganegaraan == "Bermuda") ? 'selected' : ''; ?>>Bermuda</option>
                                <option value="Bhutan" <?php echo ($siswa->kewarganegaraan == "Bhutan") ? 'selected' : ''; ?>>Bhutan</option>
                                <option value="Bolivia" <?php echo ($siswa->kewarganegaraan == "Bolivia") ? 'selected' : ''; ?>>Bolivia</option>
                                <option value="Bosnia and Herzegowina" <?php echo ($siswa->kewarganegaraan == "Bosnia and Herzegowina") ? 'selected' : ''; ?>>Bosnia and Herzegowina</option>
                                <option value="Botswana" <?php echo ($siswa->kewarganegaraan == "Botswana") ? 'selected' : ''; ?>>Botswana</option>
                                <option value="Bouvet Island" <?php echo ($siswa->kewarganegaraan == "Bouvet Island") ? 'selected' : ''; ?>>Bouvet Island</option>
                                <option value="Brazil" <?php echo ($siswa->kewarganegaraan == "Brazil") ? 'selected' : ''; ?>>Brazil</option>
                                <option value="British Indian Ocean Territory" <?php echo ($siswa->kewarganegaraan == "British Indian Ocean Territory") ? 'selected' : ''; ?>>British Indian Ocean Territory</option>
                                <option value="Brunei Darussalam" <?php echo ($siswa->kewarganegaraan == "Brunei Darussalam") ? 'selected' : ''; ?>>Brunei Darussalam</option>
                                <option value="Bulgaria" <?php echo ($siswa->kewarganegaraan == "Bulgaria") ? 'selected' : ''; ?>>Bulgaria</option>
                                <option value="Burkina Faso" <?php echo ($siswa->kewarganegaraan == "Burkina Faso") ? 'selected' : ''; ?>>Burkina Faso</option>
                                <option value="Burundi" <?php echo ($siswa->kewarganegaraan == "Burundi") ? 'selected' : ''; ?>>Burundi</option>
                                <option value="Cambodia" <?php echo ($siswa->kewarganegaraan == "Cambodia") ? 'selected' : ''; ?>>Cambodia</option>
                                <option value="Cameroon" <?php echo ($siswa->kewarganegaraan == "Cameroon") ? 'selected' : ''; ?>>Cameroon</option>
                                <option value="Canada" <?php echo ($siswa->kewarganegaraan == "Canada") ? 'selected' : ''; ?>>Canada</option>
                                <option value="Cape Verde" <?php echo ($siswa->kewarganegaraan == "Cape Verde") ? 'selected' : ''; ?>>Cape Verde</option>
                                <option value="Cayman Islands" <?php echo ($siswa->kewarganegaraan == "Cayman Islands") ? 'selected' : ''; ?>>Cayman Islands</option>
                                <option value="Central African Republic" <?php echo ($siswa->kewarganegaraan == "Central African Republic") ? 'selected' : ''; ?>>Central African Republic</option>
                                <option value="Chad" <?php echo ($siswa->kewarganegaraan == "Chad") ? 'selected' : ''; ?>>Chad</option>
                                <option value="Chile" <?php echo ($siswa->kewarganegaraan == "Chile") ? 'selected' : ''; ?>>Chile</option>
                                <option value="China" <?php echo ($siswa->kewarganegaraan == "China") ? 'selected' : ''; ?>>China</option>
                                <option value="Christmas Island" <?php echo ($siswa->kewarganegaraan == "Christmas Island") ? 'selected' : ''; ?>>Christmas Island</option>
                                <option value="Cocos Islands" <?php echo ($siswa->kewarganegaraan == "Cocos Islands") ? 'selected' : ''; ?>>Cocos (Keeling) Islands</option>
                                <option value="Colombia" <?php echo ($siswa->kewarganegaraan == "Colombia") ? 'selected' : ''; ?>>Colombia</option>
                                <option value="Comoros" <?php echo ($siswa->kewarganegaraan == "Comoros") ? 'selected' : ''; ?>>Comoros</option>
                                <option value="Congo" <?php echo ($siswa->kewarganegaraan == "Congo") ? 'selected' : ''; ?>>Congo</option>
                                <option value="Democratic Republic of the Congo" <?php echo ($siswa->kewarganegaraan == "Democratic Republic of the Congo") ? 'selected' : ''; ?>>Democratic Republic of the Congo</option>
                                <option value="Costa Rica" <?php echo ($siswa->kewarganegaraan == "Costa Rica") ? 'selected' : ''; ?>>Costa Rica</option>
                                <option value="Cote d'Ivoire" <?php echo ($siswa->kewarganegaraan == "Cote d'Ivoire") ? 'selected' : ''; ?>>Cote d'Ivoire</option>
                                <option value="Croatia" <?php echo ($siswa->kewarganegaraan == "Croatia") ? 'selected' : ''; ?>>Croatia</option>
                                <option value="Cuba" <?php echo ($siswa->kewarganegaraan == "Cuba") ? 'selected' : ''; ?>>Cuba</option>
                                <option value="Cyprus" <?php echo ($siswa->kewarganegaraan == "Cyprus") ? 'selected' : ''; ?>>Cyprus</option>
                                <option value="Czech Republic" <?php echo ($siswa->kewarganegaraan == "Czech Republic") ? 'selected' : ''; ?>>Czech Republic</option>
                                <option value="Denmark" <?php echo ($siswa->kewarganegaraan == "Denmark") ? 'selected' : ''; ?>>Denmark</option>
                                <option value="Djibouti" <?php echo ($siswa->kewarganegaraan == "Djibouti") ? 'selected' : ''; ?>>Djibouti</option>
                                <option value="Dominica" <?php echo ($siswa->kewarganegaraan == "Dominica") ? 'selected' : ''; ?>>Dominica</option>
                                <option value="Dominican Republic" <?php echo ($siswa->kewarganegaraan == "Dominican Republic") ? 'selected' : ''; ?>>Dominican Republic</option>
                                <option value="Ecuador" <?php echo ($siswa->kewarganegaraan == "Ecuador") ? 'selected' : ''; ?>>Ecuador</option>
                                <option value="Egypt" <?php echo ($siswa->kewarganegaraan == "Egypt") ? 'selected' : ''; ?>>Egypt</option>
                                <option value="El Salvador" <?php echo ($siswa->kewarganegaraan == "El Salvador") ? 'selected' : ''; ?>>El Salvador</option>
                                <option value="Equatorial Guinea" <?php echo ($siswa->kewarganegaraan == "Equatorial Guinea") ? 'selected' : ''; ?>>Equatorial Guinea</option>
                                <option value="Eritrea" <?php echo ($siswa->kewarganegaraan == "Eritrea") ? 'selected' : ''; ?>>Eritrea</option>
                                <option value="Estonia" <?php echo ($siswa->kewarganegaraan == "Estonia") ? 'selected' : ''; ?>>Estonia</option>
                                <option value="Eswatini" <?php echo ($siswa->kewarganegaraan == "Eswatini") ? 'selected' : ''; ?>>Eswatini</option>
                                <option value="Ethiopia" <?php echo ($siswa->kewarganegaraan == "Ethiopia") ? 'selected' : ''; ?>>Ethiopia</option>
                                <option value="Falkland Islands" <?php echo ($siswa->kewarganegaraan == "Falkland Islands") ? 'selected' : ''; ?>>Falkland Islands</option>
                                <option value="Faroe Islands" <?php echo ($siswa->kewarganegaraan == "Faroe Islands") ? 'selected' : ''; ?>>Faroe Islands</option>
                                <option value="Fiji" <?php echo ($siswa->kewarganegaraan == "Fiji") ? 'selected' : ''; ?>>Fiji</option>
                                <option value="Finland" <?php echo ($siswa->kewarganegaraan == "Finland") ? 'selected' : ''; ?>>Finland</option>
                                <option value="France" <?php echo ($siswa->kewarganegaraan == "France") ? 'selected' : ''; ?>>France</option>
                                <option value="Gabon" <?php echo ($siswa->kewarganegaraan == "Gabon") ? 'selected' : ''; ?>>Gabon</option>
                                <option value="Gambia" <?php echo ($siswa->kewarganegaraan == "Gambia") ? 'selected' : ''; ?>>Gambia</option>
                                <option value="Georgia" <?php echo ($siswa->kewarganegaraan == "Georgia") ? 'selected' : ''; ?>>Georgia</option>
                                <option value="Germany" <?php echo ($siswa->kewarganegaraan == "Germany") ? 'selected' : ''; ?>>Germany</option>
                                <option value="Ghana" <?php echo ($siswa->kewarganegaraan == "Ghana") ? 'selected' : ''; ?>>Ghana</option>
                                <option value="Gibraltar" <?php echo ($siswa->kewarganegaraan == "Gibraltar") ? 'selected' : ''; ?>>Gibraltar</option>
                                <option value="Greece" <?php echo ($siswa->kewarganegaraan == "Greece") ? 'selected' : ''; ?>>Greece</option>
                                <option value="Greenland" <?php echo ($siswa->kewarganegaraan == "Greenland") ? 'selected' : ''; ?>>Greenland</option>
                                <option value="Grenada" <?php echo ($siswa->kewarganegaraan == "Grenada") ? 'selected' : ''; ?>>Grenada</option>
                                <option value="Guadeloupe" <?php echo ($siswa->kewarganegaraan == "Guadeloupe") ? 'selected' : ''; ?>>Guadeloupe</option>
                                <option value="Guam" <?php echo ($siswa->kewarganegaraan == "Guam") ? 'selected' : ''; ?>>Guam</option>
                                <option value="Guatemala" <?php echo ($siswa->kewarganegaraan == "Guatemala") ? 'selected' : ''; ?>>Guatemala</option>
                                <option value="Guinea" <?php echo ($siswa->kewarganegaraan == "Guinea") ? 'selected' : ''; ?>>Guinea</option>
                                <option value="Guinea-Bissau" <?php echo ($siswa->kewarganegaraan == "Guinea-Bissau") ? 'selected' : ''; ?>>Guinea-Bissau</option>
                                <option value="Guyana" <?php echo ($siswa->kewarganegaraan == "Guyana") ? 'selected' : ''; ?>>Guyana</option>
                                <option value="Haiti" <?php echo ($siswa->kewarganegaraan == "Haiti") ? 'selected' : ''; ?>>Haiti</option>
                                <option value="Honduras" <?php echo ($siswa->kewarganegaraan == "Honduras") ? 'selected' : ''; ?>>Honduras</option>
                                <option value="Hong Kong" <?php echo ($siswa->kewarganegaraan == "Hong Kong") ? 'selected' : ''; ?>>Hong Kong</option>
                                <option value="Hungary" <?php echo ($siswa->kewarganegaraan == "Hungary") ? 'selected' : ''; ?>>Hungary</option>
                                <option value="Iceland" <?php echo ($siswa->kewarganegaraan == "Iceland") ? 'selected' : ''; ?>>Iceland</option>
                                <option value="India" <?php echo ($siswa->kewarganegaraan == "India") ? 'selected' : ''; ?>>India</option>
                                <option value="Iran" <?php echo ($siswa->kewarganegaraan == "Iran") ? 'selected' : ''; ?>>Iran</option>
                                <option value="Iraq" <?php echo ($siswa->kewarganegaraan == "Iraq") ? 'selected' : ''; ?>>Iraq</option>
                                <option value="Ireland" <?php echo ($siswa->kewarganegaraan == "Ireland") ? 'selected' : ''; ?>>Ireland</option>
                                <option value="Isle of Man" <?php echo ($siswa->kewarganegaraan == "Isle of Man") ? 'selected' : ''; ?>>Isle of Man</option>
                                <option value="Israel" <?php echo ($siswa->kewarganegaraan == "Israel") ? 'selected' : ''; ?>>Israel</option>
                                <option value="Italy" <?php echo ($siswa->kewarganegaraan == "Italy") ? 'selected' : ''; ?>>Italy</option>
                                <option value="Jamaica" <?php echo ($siswa->kewarganegaraan == "Jamaica") ? 'selected' : ''; ?>>Jamaica</option>
                                <option value="Japan" <?php echo ($siswa->kewarganegaraan == "Japan") ? 'selected' : ''; ?>>Japan</option>
                                <option value="Jersey" <?php echo ($siswa->kewarganegaraan == "Jersey") ? 'selected' : ''; ?>>Jersey</option>
                                <option value="Jordan" <?php echo ($siswa->kewarganegaraan == "Jordan") ? 'selected' : ''; ?>>Jordan</option>
                                <option value="Kazakhstan" <?php echo ($siswa->kewarganegaraan == "Kazakhstan") ? 'selected' : ''; ?>>Kazakhstan</option>
                                <option value="Kenya" <?php echo ($siswa->kewarganegaraan == "Kenya") ? 'selected' : ''; ?>>Kenya</option>
                                <option value="Kiribati" <?php echo ($siswa->kewarganegaraan == "Kiribati") ? 'selected' : ''; ?>>Kiribati</option>
                                <option value="Kuwait" <?php echo ($siswa->kewarganegaraan == "Kuwait") ? 'selected' : ''; ?>>Kuwait</option>
                                <option value="Kyrgyzstan" <?php echo ($siswa->kewarganegaraan == "Kyrgyzstan") ? 'selected' : ''; ?>>Kyrgyzstan</option>
                                <option value="Laos" <?php echo ($siswa->kewarganegaraan == "Laos") ? 'selected' : ''; ?>>Laos</option>
                                <option value="Latvia" <?php echo ($siswa->kewarganegaraan == "Latvia") ? 'selected' : ''; ?>>Latvia</option>
                                <option value="Lebanon" <?php echo ($siswa->kewarganegaraan == "Lebanon") ? 'selected' : ''; ?>>Lebanon</option>
                                <option value="Lesotho" <?php echo ($siswa->kewarganegaraan == "Lesotho") ? 'selected' : ''; ?>>Lesotho</option>
                                <option value="Liberia" <?php echo ($siswa->kewarganegaraan == "Liberia") ? 'selected' : ''; ?>>Liberia</option>
                                <option value="Libya" <?php echo ($siswa->kewarganegaraan == "Libya") ? 'selected' : ''; ?>>Libya</option>
                                <option value="Liechtenstein" <?php echo ($siswa->kewarganegaraan == "Liechtenstein") ? 'selected' : ''; ?>>Liechtenstein</option>
                                <option value="Lithuania" <?php echo ($siswa->kewarganegaraan == "Lithuania") ? 'selected' : ''; ?>>Lithuania</option>
                                <option value="Luxembourg" <?php echo ($siswa->kewarganegaraan == "Luxembourg") ? 'selected' : ''; ?>>Luxembourg</option>
                                <option value="Macau" <?php echo ($siswa->kewarganegaraan == "Macau") ? 'selected' : ''; ?>>Macau</option>
                                <option value="Madagascar" <?php echo ($siswa->kewarganegaraan == "Madagascar") ? 'selected' : ''; ?>>Madagascar</option>
                                <option value="Malawi" <?php echo ($siswa->kewarganegaraan == "Malawi") ? 'selected' : ''; ?>>Malawi</option>
                                <option value="Malaysia" <?php echo ($siswa->kewarganegaraan == "Malaysia") ? 'selected' : ''; ?>>Malaysia</option>
                                <option value="Maldives" <?php echo ($siswa->kewarganegaraan == "Maldives") ? 'selected' : ''; ?>>Maldives</option>
                                <option value="Mali" <?php echo ($siswa->kewarganegaraan == "Mali") ? 'selected' : ''; ?>>Mali</option>
                                <option value="Malta" <?php echo ($siswa->kewarganegaraan == "Malta") ? 'selected' : ''; ?>>Malta</option>
                                <option value="Marshall Islands" <?php echo ($siswa->kewarganegaraan == "Marshall Islands") ? 'selected' : ''; ?>>Marshall Islands</option>
                                <option value="Mauritania" <?php echo ($siswa->kewarganegaraan == "Mauritania") ? 'selected' : ''; ?>>Mauritania</option>
                                <option value="Mauritius" <?php echo ($siswa->kewarganegaraan == "Mauritius") ? 'selected' : ''; ?>>Mauritius</option>
                                <option value="Mexico" <?php echo ($siswa->kewarganegaraan == "Mexico") ? 'selected' : ''; ?>>Mexico</option>
                                <option value="Micronesia" <?php echo ($siswa->kewarganegaraan == "Micronesia") ? 'selected' : ''; ?>>Micronesia</option>
                                <option value="Moldova" <?php echo ($siswa->kewarganegaraan == "Moldova") ? 'selected' : ''; ?>>Moldova</option>
                                <option value="Monaco" <?php echo ($siswa->kewarganegaraan == "Monaco") ? 'selected' : ''; ?>>Monaco</option>
                                <option value="Mongolia" <?php echo ($siswa->kewarganegaraan == "Mongolia") ? 'selected' : ''; ?>>Mongolia</option>
                                <option value="Montenegro" <?php echo ($siswa->kewarganegaraan == "Montenegro") ? 'selected' : ''; ?>>Montenegro</option>
                                <option value="Morocco" <?php echo ($siswa->kewarganegaraan == "Morocco") ? 'selected' : ''; ?>>Morocco</option>
                                <option value="Mozambique" <?php echo ($siswa->kewarganegaraan == "Mozambique") ? 'selected' : ''; ?>>Mozambique</option>
                                <option value="Myanmar" <?php echo ($siswa->kewarganegaraan == "Myanmar") ? 'selected' : ''; ?>>Myanmar</option>
                                <option value="Namibia" <?php echo ($siswa->kewarganegaraan == "Namibia") ? 'selected' : ''; ?>>Namibia</option>
                                <option value="Nauru" <?php echo ($siswa->kewarganegaraan == "Nauru") ? 'selected' : ''; ?>>Nauru</option>
                                <option value="Nepal" <?php echo ($siswa->kewarganegaraan == "Nepal") ? 'selected' : ''; ?>>Nepal</option>
                                <option value="Netherlands" <?php echo ($siswa->kewarganegaraan == "Netherlands") ? 'selected' : ''; ?>>Netherlands</option>
                                <option value="New Zealand" <?php echo ($siswa->kewarganegaraan == "New Zealand") ? 'selected' : ''; ?>>New Zealand</option>
                                <option value="Nicaragua" <?php echo ($siswa->kewarganegaraan == "Nicaragua") ? 'selected' : ''; ?>>Nicaragua</option>
                                <option value="Niger" <?php echo ($siswa->kewarganegaraan == "Niger") ? 'selected' : ''; ?>>Niger</option>
                                <option value="Nigeria" <?php echo ($siswa->kewarganegaraan == "Nigeria") ? 'selected' : ''; ?>>Nigeria</option>
                                <option value="North Macedonia" <?php echo ($siswa->kewarganegaraan == "North Macedonia") ? 'selected' : ''; ?>>North Macedonia</option>
                                <option value="Northern Mariana Islands" <?php echo ($siswa->kewarganegaraan == "Northern Mariana Islands") ? 'selected' : ''; ?>>Northern Mariana Islands</option>
                                <option value="Norway" <?php echo ($siswa->kewarganegaraan == "Norway") ? 'selected' : ''; ?>>Norway</option>
                                <option value="Oman" <?php echo ($siswa->kewarganegaraan == "Oman") ? 'selected' : ''; ?>>Oman</option>
                                <option value="Pakistan" <?php echo ($siswa->kewarganegaraan == "Pakistan") ? 'selected' : ''; ?>>Pakistan</option>
                                <option value="Palau" <?php echo ($siswa->kewarganegaraan == "Palau") ? 'selected' : ''; ?>>Palau</option>
                                <option value="Palestine" <?php echo ($siswa->kewarganegaraan == "Palestine") ? 'selected' : ''; ?>>Palestine</option>
                                <option value="Panama" <?php echo ($siswa->kewarganegaraan == "Panama") ? 'selected' : ''; ?>>Panama</option>
                                <option value="Papua New Guinea" <?php echo ($siswa->kewarganegaraan == "Papua New Guinea") ? 'selected' : ''; ?>>Papua New Guinea</option>
                                <option value="Paraguay" <?php echo ($siswa->kewarganegaraan == "Paraguay") ? 'selected' : ''; ?>>Paraguay</option>
                                <option value="Peru" <?php echo ($siswa->kewarganegaraan == "Peru") ? 'selected' : ''; ?>>Peru</option>
                                <option value="Philippines" <?php echo ($siswa->kewarganegaraan == "Philippines") ? 'selected' : ''; ?>>Philippines</option>
                                <option value="Poland" <?php echo ($siswa->kewarganegaraan == "Poland") ? 'selected' : ''; ?>>Poland</option>
                                <option value="Portugal" <?php echo ($siswa->kewarganegaraan == "Portugal") ? 'selected' : ''; ?>>Portugal</option>
                                <option value="Qatar" <?php echo ($siswa->kewarganegaraan == "Qatar") ? 'selected' : ''; ?>>Qatar</option>
                                <option value="Romania" <?php echo ($siswa->kewarganegaraan == "Romania") ? 'selected' : ''; ?>>Romania</option>
                                <option value="Russia" <?php echo ($siswa->kewarganegaraan == "Russia") ? 'selected' : ''; ?>>Russia</option>
                                <option value="Rwanda" <?php echo ($siswa->kewarganegaraan == "Rwanda") ? 'selected' : ''; ?>>Rwanda</option>
                                <option value="Saint Kitts and Nevis" <?php echo ($siswa->kewarganegaraan == "Saint Kitts and Nevis") ? 'selected' : ''; ?>>Saint Kitts and Nevis</option>
                                <option value="Saint Lucia" <?php echo ($siswa->kewarganegaraan == "Saint Lucia") ? 'selected' : ''; ?>>Saint Lucia</option>
                                <option value="Saint Vincent and the Grenadines" <?php echo ($siswa->kewarganegaraan == "Saint Vincent and the Grenadines") ? 'selected' : ''; ?>>Saint Vincent and the Grenadines</option>
                                <option value="Samoa" <?php echo ($siswa->kewarganegaraan == "Samoa") ? 'selected' : ''; ?>>Samoa</option>
                                <option value="San Marino" <?php echo ($siswa->kewarganegaraan == "San Marino") ? 'selected' : ''; ?>>San Marino</option>
                                <option value="Sao Tome and Principe" <?php echo ($siswa->kewarganegaraan == "Sao Tome and Principe") ? 'selected' : ''; ?>>Sao Tome and Principe</option>
                                <option value="Saudi Arabia" <?php echo ($siswa->kewarganegaraan == "Saudi Arabia") ? 'selected' : ''; ?>>Saudi Arabia</option>
                                <option value="Senegal" <?php echo ($siswa->kewarganegaraan == "Senegal") ? 'selected' : ''; ?>>Senegal</option>
                                <option value="Serbia" <?php echo ($siswa->kewarganegaraan == "Serbia") ? 'selected' : ''; ?>>Serbia</option>
                                <option value="Seychelles" <?php echo ($siswa->kewarganegaraan == "Seychelles") ? 'selected' : ''; ?>>Seychelles</option>
                                <option value="Sierra Leone" <?php echo ($siswa->kewarganegaraan == "Sierra Leone") ? 'selected' : ''; ?>>Sierra Leone</option>
                                <option value="Singapore" <?php echo ($siswa->kewarganegaraan == "Singapore") ? 'selected' : ''; ?>>Singapore</option>
                                <option value="Slovakia" <?php echo ($siswa->kewarganegaraan == "Slovakia") ? 'selected' : ''; ?>>Slovakia</option>
                                <option value="Slovenia" <?php echo ($siswa->kewarganegaraan == "Slovenia") ? 'selected' : ''; ?>>Slovenia</option>
                                <option value="Solomon Islands" <?php echo ($siswa->kewarganegaraan == "Solomon Islands") ? 'selected' : ''; ?>>Solomon Islands</option>
                                <option value="Somalia" <?php echo ($siswa->kewarganegaraan == "Somalia") ? 'selected' : ''; ?>>Somalia</option>
                                <option value="South Africa" <?php echo ($siswa->kewarganegaraan == "South Africa") ? 'selected' : ''; ?>>South Africa</option>
                                <option value="South Korea" <?php echo ($siswa->kewarganegaraan == "South Korea") ? 'selected' : ''; ?>>South Korea</option>
                                <option value="South Sudan" <?php echo ($siswa->kewarganegaraan == "South Sudan") ? 'selected' : ''; ?>>South Sudan</option>
                                <option value="Spain" <?php echo ($siswa->kewarganegaraan == "Spain") ? 'selected' : ''; ?>>Spain</option>
                                <option value="Sri Lanka" <?php echo ($siswa->kewarganegaraan == "Sri Lanka") ? 'selected' : ''; ?>>Sri Lanka</option>
                                <option value="Sudan" <?php echo ($siswa->kewarganegaraan == "Sudan") ? 'selected' : ''; ?>>Sudan</option>
                                <option value="Suriname" <?php echo ($siswa->kewarganegaraan == "Suriname") ? 'selected' : ''; ?>>Suriname</option>
                                <option value="Sweden" <?php echo ($siswa->kewarganegaraan == "Sweden") ? 'selected' : ''; ?>>Sweden</option>
                                <option value="Switzerland" <?php echo ($siswa->kewarganegaraan == "Switzerland") ? 'selected' : ''; ?>>Switzerland</option>
                                <option value="Syria" <?php echo ($siswa->kewarganegaraan == "Syria") ? 'selected' : ''; ?>>Syria</option>
                                <option value="Taiwan" <?php echo ($siswa->kewarganegaraan == "Taiwan") ? 'selected' : ''; ?>>Taiwan</option>
                                <option value="Tajikistan" <?php echo ($siswa->kewarganegaraan == "Tajikistan") ? 'selected' : ''; ?>>Tajikistan</option>
                                <option value="Tanzania" <?php echo ($siswa->kewarganegaraan == "Tanzania") ? 'selected' : ''; ?>>Tanzania</option>
                                <option value="Thailand" <?php echo ($siswa->kewarganegaraan == "Thailand") ? 'selected' : ''; ?>>Thailand</option>
                                <option value="Timor-Leste" <?php echo ($siswa->kewarganegaraan == "Timor-Leste") ? 'selected' : ''; ?>>Timor-Leste</option>
                                <option value="Togo" <?php echo ($siswa->kewarganegaraan == "Togo") ? 'selected' : ''; ?>>Togo</option>
                                <option value="Tonga" <?php echo ($siswa->kewarganegaraan == "Tonga") ? 'selected' : ''; ?>>Tonga</option>
                                <option value="Trinidad and Tobago" <?php echo ($siswa->kewarganegaraan == "Trinidad and Tobago") ? 'selected' : ''; ?>>Trinidad and Tobago</option>
                                <option value="Tunisia" <?php echo ($siswa->kewarganegaraan == "Tunisia") ? 'selected' : ''; ?>>Tunisia</option>
                                <option value="Turkey" <?php echo ($siswa->kewarganegaraan == "Turkey") ? 'selected' : ''; ?>>Turkey</option>
                                <option value="Turkmenistan" <?php echo ($siswa->kewarganegaraan == "Turkmenistan") ? 'selected' : ''; ?>>Turkmenistan</option>
                                <option value="Tuvalu" <?php echo ($siswa->kewarganegaraan == "Tuvalu") ? 'selected' : ''; ?>>Tuvalu</option>
                                <option value="Uganda" <?php echo ($siswa->kewarganegaraan == "Uganda") ? 'selected' : ''; ?>>Uganda</option>
                                <option value="Ukraine" <?php echo ($siswa->kewarganegaraan == "Ukraine") ? 'selected' : ''; ?>>Ukraine</option>
                                <option value="United Arab Emirates" <?php echo ($siswa->kewarganegaraan == "United Arab Emirates") ? 'selected' : ''; ?>>United Arab Emirates</option>
                                <option value="United Kingdom" <?php echo ($siswa->kewarganegaraan == "United Kingdom") ? 'selected' : ''; ?>>United Kingdom</option>
                                <option value="United States of America" <?php echo ($siswa->kewarganegaraan == "United States of America") ? 'selected' : ''; ?>>United States of America</option>
                                <option value="Uruguay" <?php echo ($siswa->kewarganegaraan == "Uruguay") ? 'selected' : ''; ?>>Uruguay</option>
                                <option value="Uzbekistan" <?php echo ($siswa->kewarganegaraan == "Uzbekistan") ? 'selected' : ''; ?>>Uzbekistan</option>
                                <option value="Vanuatu" <?php echo ($siswa->kewarganegaraan == "Vanuatu") ? 'selected' : ''; ?>>Vanuatu</option>
                                <option value="Vatican City" <?php echo ($siswa->kewarganegaraan == "Vatican City") ? 'selected' : ''; ?>>Vatican City</option>
                                <option value="Venezuela" <?php echo ($siswa->kewarganegaraan == "Venezuela") ? 'selected' : ''; ?>>Venezuela</option>
                                <option value="Vietnam" <?php echo ($siswa->kewarganegaraan == "Vietnam") ? 'selected' : ''; ?>>Vietnam</option>
                                <option value="Yemen" <?php echo ($siswa->kewarganegaraan == "Yemen") ? 'selected' : ''; ?>>Yemen</option>
                                <option value="Zambia" <?php echo ($siswa->kewarganegaraan == "Zambia") ? 'selected' : ''; ?>>Zambia</option>
                                <option value="Zimbabwe" <?php echo ($siswa->kewarganegaraan == "Zimbabwe") ? 'selected' : ''; ?>>Zimbabwe</option>
                            </select>  
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-wrapper">
                        <label>Agama<span style="color: red;">*</span></label>
                        <div class="form-holder select">
                            <select id="agama" name="agama" class="form-control">
                                <option value="-" disable>- Pilih Agama -</option>
                                <option value="Islam" <?php if($siswa->agama == "Islam"){ echo 'selected'; }?>>Islam</option>
                                <option value="Kristen" <?php if($siswa->agama == "Kristen"){ echo 'selected'; }?>>Kristen</option>
                                <option value="Hindu" <?php if($siswa->agama == "Hindu"){ echo 'selected'; }?>>Hindu</option>
                                <option value="Budha" <?php if($siswa->agama == "Budha"){ echo 'selected'; }?>>Budha</option>
                                <option value="Katolik" <?php if($siswa->agama == "Katolik"){ echo 'selected'; }?>>Katolik</option>
                                <option value="Konghuchu" <?php if($siswa->agama == "Konghuchu"){ echo 'selected'; }?>>Konghuchu</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-wrapper">
                        <label>Alamat<span style="color: red;">*</span></label>
                        <div class="form-holder">
                            <input id="domisili" name="domisili" type="text" class="form-control" value="<?php echo $siswa->domisili; ?>" autocomplete="off">
                        </div>
                    </div>
                </div>    
                <div id="alamatSection" class="form-group" style="display: none;">
                <div class="form-group">
                    <div class="form-wrapper">
                        <label>Provinsi<span style="color: red;">*</span></label>
                        <div class="form-holder">
                            <select class="form-control" id="provinsi" name="provinsi" onchange="pilih_kabupaten();">
                                <option value="-">- Pilih Provinsi -</option>
                                <?php
                                foreach ($provinsi->getResult() as $row) {
                                ?>
                                    <option value="<?php echo $row->idprovinsi; ?>"  <?php if($siswa->provinsi == $row->idprovinsi){ echo 'selected'; }?>> <?php echo $row->nama; ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-wrapper">
                        <label>Kota / Kabupaten<span style="color: red;">*</span> </label>
                        <div class="form-holder">
                            <select class="form-control" id="kabupaten" name="kabupaten" onchange="pilih_kecamatan();">
                                <option value="-">- Pilih Kabupaten -</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-wrapper">
                        <label>Kecamatan<span style="color: red;">*</span></label>
                        <div class="form-holder">
                            <select class="form-control" id="kecamatan" name="kecamatan" onchange="pilih_kelurahan();">
                                <option value="-">- Pilih Kecamatan -</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-wrapper">
                        <label>Kelurahan<span style="color: red;">*</span> </label>
                        <div class="form-holder">
                            <select class="form-control" id="kelurahan" name="kelurahan">
                                <option value="-">- Pilih Kelurahan -</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-wrapper">
                        <label>Kodepos<span style="color: red;">*</span></label>
                        <div class="form-holder">
                            <input id="kodepos" name="kodepos"  onkeypress="return hanyaAngka(event,false);" type="text" class="form-control" value="<?php echo $siswa->kodepos; ?>" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-wrapper">
                        <label>RT</label>
                        <div class="form-holder">
                            <input id="rt" name="rt" type="text"  onkeypress="return hanyaAngka(event,false);" class="form-control" value="<?php echo $siswa->rt; ?>"  autocomplete="off">
                        </div>
                    </div>
                    <div class="form-wrapper">
                        <label>RW</label>
                        <div class="form-holder">
                            <input id="rw" name="rw" type="text"  onkeypress="return hanyaAngka(event,false);" class="form-control" value="<?php echo $siswa->rw; ?>" autocomplete="off">
                        </div>
                    </div>                
                </div>  
                </div>
                <div class="form-group">
                    <div class="form-wrapper">
                        <label>Nama Sekolah<span style="color: red;">*</span></label>
                        <div class="form-holder">
                            <input id="sekolah" name="sekolah" type="text" class="form-control" value="<?php echo $siswa->nama_sekolah; ?>" autocomplete="off">
                        </div>
                        <small class="invalid-feedback">Tulislah nama sekolahmu dengan lengkap dan benar tanpa singkatan, contoh : SD Negeri Rungkut 1 Surabaya</small>
                    </div>
                    <div class="form-wrapper">
                        <label>Level Pendidikan Siswa<span style="color: red;">*</span></label>
                        <div class="form-holder">
                            <select class="form-control" id="level_pendidikan" name="level_pendidikan">
                                <option value="-" disabled>- Pilih Level Pendidikan Siswa -</option>
                                <option value="TK" <?php if($siswa->level_sekolah == "TK"){ echo 'selected'; }?>>TK</option>
                                <option value="SD" <?php if($siswa->level_sekolah == "SD"){ echo 'selected'; }?>>SD</option>
                                <option value="SMP" <?php if($siswa->level_sekolah == "SMP"){ echo 'selected'; }?>>SMP</option>
                                <option value="SMA" <?php if($siswa->level_sekolah == "SMA"){ echo 'selected'; }?>>SMA</option>
                                <option value="D3" <?php if($siswa->level_sekolah == "D3"){ echo 'selected'; }?>>D3</option>
                                <option value="D4" <?php if($siswa->level_sekolah == "D4"){ echo 'selected'; }?>>D4</option>
                                <option value="S1" <?php if($siswa->level_sekolah == "S1"){ echo 'selected'; }?>>S1</option>
                                <option value="S2" <?php if($siswa->level_sekolah == "S2"){ echo 'selected'; }?>>S2</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-wrapper" style="width:100%">
                        <label>Status Pendaftaran Leap English Course<span style="color: red;">*</span></label>
                        <div class="form-holder">
                            <select id="status" name="status" class="form-control">
                                <option value="-" disabled>- Pilih Status Siswa -</option>
                                <option value="Siswa Baru" <?php if($siswa->statussiswa == "Siswa Baru"){ echo 'selected'; }?>>Siswa Baru</option>
                                <option value="Siswa Lama" <?php if($siswa->statussiswa == "Siswa Lama"){ echo 'selected'; }?>>Siswa Lama</option>
                            </select>
                        </div>
                    </div>
                </div>    
                <div class="form-group">
                    <div class="form-wrapper" style="width:100%">
                        <label>Darimanakah Anda memperoleh informasi tentang kelas online LEAP English ini?</label>
                        <div class="form-holder">
                            <select id="info" name="info" class="form-control">
                                <option value="-" disabled>- Pilih Informasi -</option>
                                <option value="teman" <?php if($siswa->info == "teman"){ echo 'selected'; }?>>Teman</option>
                                <option value="saudara" <?php if($siswa->info == "saudara"){ echo 'selected'; }?>>Saudara</option>
                                <option value="onsite" <?php if($siswa->info == "onsite"){ echo 'selected'; }?>>Onsite</option>
                                <option value="sekolah" <?php if($siswa->info == "sekolah"){ echo 'selected'; }?>>Sekolah</option>
                                <option value="ig" <?php if($siswa->info == "ig"){ echo 'selected'; }?>>IG (Instagram)</option>
                                <option value="fb" <?php if($siswa->info == "fb"){ echo 'selected'; }?>>FB (Facebook)</option>
                                <option value="tiktok" <?php if($siswa->info == "tiktok"){ echo 'selected'; }?>>TikTok</option>
                                <option value="website" <?php if($siswa->info == "website"){ echo 'selected'; }?>>Website</option>
                                <option value="lainnya" <?php if($siswa->info == "lainnya"){ echo 'selected'; }?>>Lainnya</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-wrapper" style="width:100%">
                        <label>Siapa nama teman/kerabat/instansi/sekolah yang merekomendasikan Anda untuk bergabung di Leap?</label>
                        <div class="form-holder">
                            <input id="rekomen" name="rekomen" type="text" value="<?php echo $siswa->rekomen; ?>" class="form-control" autocomplete="off">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-wrapper" style="width:100%">
                        <label>Bukti Pembayaran Registrasi Ulang</label>
                        <div class="form-holder">
                            <input type="file" id="foto" class="form-control" name="foto">
                        </div>
                        <small class="invalid-feedback">*Hanya untuk siswa baru</small>      
                    </div>
                </div>
                <div class="form-end">
                    <div class="checkbox"></div>
                    <div class="button-holder">
                        <button type="button" id="btnSave" onclick="save();">Next</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>
<script src="<?php echo base_url(); ?>back/assets/js/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>izitoast/js/iziToast.min.js"></script>
<script>
    function save() {
        var nama_lengkap = document.getElementById('nama_lengkap').value;
        var idsiswa = document.getElementById('idsiswa').value;
        var tmp_lahir = document.getElementById('tmp_lahir').value;
        var panggilan = document.getElementById('panggilan').value;
        var tgl_lahir = document.getElementById('tgl_lahir').value;
        var nisn = document.getElementById('nisn').value;
        var jkel = document.getElementById('jkel').value;
        var nik = document.getElementById('nik').value;
        var domisili = document.getElementById('domisili').value;
        var kewarganegaraan = document.getElementById('kewarganegaraan').value;
        var agama = document.getElementById('agama').value;
        var provinsi = document.getElementById('provinsi').value;
        var kabupaten = document.getElementById('kabupaten').value;
        var kecamatan = document.getElementById('kecamatan').value;
        var kelurahan = document.getElementById('kelurahan').value;
        var kodepos = document.getElementById('kodepos').value;
        var rt = document.getElementById('rt').value;
        var rw = document.getElementById('rw').value;
        var sekolah = document.getElementById('sekolah').value;
        var status = document.getElementById('status').value;
        var info = document.getElementById('info').value;
        var rekomen = document.getElementById('rekomen').value;
        var level_pendidikan = document.getElementById('level_pendidikan').value;
        var foto = $('#foto').prop('files')[0];
        
        if (kewarganegaraan === 'Indonesia') {
            if (provinsi === '-' || provinsi === '') {
                document.getElementById('provinsi').focus();
                alert("Provinsi harus diisi");
                return; // Menghentikan eksekusi
            } else if (kabupaten === '-' || kabupaten === '') {
                document.getElementById('kabupaten').focus();
                alert("Kabupaten harus diisi");
                return;
            } else if (kecamatan === '-' || kecamatan === '') {
                document.getElementById('kecamatan').focus();
                alert("Kecamatan harus diisi");
                return;
            } else if (kelurahan === '-' || kelurahan === '') {
                document.getElementById('kelurahan').focus();
                alert("Kelurahan harus diisi");
                return;
            } else if (kodepos === '') {
                document.getElementById('kodepos').focus();
                alert("Kodepos harus diisi");
                return;
            }
        }

        // Validasi lainnya
        if (nama_lengkap === '') {
            alert("Nama Lengkap harus diisi");
            document.getElementById('nama_lengkap').focus();
            return;
        } else if (tmp_lahir === '') {
            alert("Tempat Lahir harus diisi");
            document.getElementById('tmp_lahir').focus();
            return;
        } else if (panggilan === '') {
            alert("Nama Panggilan harus diisi");
            document.getElementById('panggilan').focus();
            return;
        } else if (tgl_lahir === '') {
            alert("Tanggal Lahir harus diisi");
            document.getElementById('tgl_lahir').focus();
            return;
        } else if (nik === '') {
            document.getElementById('nik').focus();
            alert("NIK Siswa harus diisi");
            return;
        } else if (jkel === '-') {
            document.getElementById('jkel').focus();
            alert("Jenis Kelamin harus diisi");
            return;
        } else if (kewarganegaraan === '-') {
            document.getElementById('kewarganegaraan').focus();
            alert("Kewarganegaraan harus diisi");
            return;
        } else if (domisili === '') {
            document.getElementById('domisili').focus();
            alert("Alamat harus diisi");
            return;
        } else if (agama === '-') {
            document.getElementById('agama').focus();
            alert("Agama harus diisi");
            return;
        } else if (sekolah === '') {
            document.getElementById('sekolah').focus();
            alert("Nama Sekolah harus diisi");
            return;
        } else if (level_pendidikan === '') {
            document.getElementById('level_pendidikan').focus();
            alert("Level pendidikan harus diisi");
            return;
        } else if (status === '-') {
            document.getElementById('status').focus();
            alert("Status Siswa harus diisi");
            return;
        }else{
            var form_data = new FormData();
            form_data.append('nama_lengkap', nama_lengkap);
            form_data.append('idsiswa', idsiswa);
            form_data.append('tmp_lahir', tmp_lahir);
            form_data.append('panggilan', panggilan);
            form_data.append('tgl_lahir', tgl_lahir);
            form_data.append('nisn', nisn);
            form_data.append('jkel', jkel);
            form_data.append('nik', nik);
            form_data.append('domisili', domisili);
            form_data.append('kewarganegaraan', kewarganegaraan);
            form_data.append('agama', agama);
            form_data.append('provinsi', provinsi);
            form_data.append('kabupaten', kabupaten);
            form_data.append('kecamatan', kecamatan);
            form_data.append('kelurahan', kelurahan);
            form_data.append('kodepos', kodepos);
            form_data.append('rt', rt);
            form_data.append('rw', rw);
            form_data.append('sekolah', sekolah);
            form_data.append('level_pendidikan', level_pendidikan);
            form_data.append('status', status);
            form_data.append('info', info);
            form_data.append('rekomen', rekomen);
            form_data.append('file', foto);

            $('#btnSave').text('Proses...');
            $('#btnSave').attr('disabled', false);

            $.ajax({
                url: "<?php echo base_url(); ?>registrasiulang/proses",
                dataType: 'JSON',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                type: 'POST',
                success: function (response) {
                    if(response.status == "ok"){
                      window.location.href = '<?php echo base_url().'registrasiulang/form2/' ?>'+response.id;
                    }else{
                        alert(response.status);
                    }
                
                    $('#btnSave').text('Next');
                    $('#btnSave').attr('disabled', true);
                },error: function (response) {
                    alert(response.status);
                }
            });
        }
    }

    function pilih_kabupaten() {
        var provinsi = document.getElementById('provinsi').value;
        var form_data = new FormData();
        form_data.append('provinsi', provinsi);

        $.ajax({
            url: "<?php echo base_url(); ?>registrasiulang/kabupaten",
            dataType: 'JSON',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: 'POST',
            success: function(data) {
                $('#kabupaten').html(data.status);
                $('[name="kabupaten"]').val("<?php echo $siswa->kabupaten; ?>");
                pilih_kecamatan();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                iziToast.error({
                    title: 'Error',
                    message: "Error json " + errorThrown,
                    position: 'topRight'
                });
            }
        });
    }

    function pilih_kecamatan() {
        var kabupaten = document.getElementById('kabupaten').value;
        var form_data = new FormData();
        form_data.append('kabupaten', kabupaten);

        $.ajax({
            url: "<?php echo base_url(); ?>registrasiulang/kecamatan",
            dataType: 'JSON',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: 'POST',
            success: function(data) {
                $('#kecamatan').html(data.status);
                $('[name="kecamatan"]').val("<?php echo $siswa->kecamatan; ?>");
                pilih_kelurahan();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                iziToast.error({
                    title: 'Error',
                    message: "Error json " + errorThrown,
                    position: 'topRight'
                });
            }
        });
    }

    function pilih_kelurahan() {
        var kecamatan = document.getElementById('kecamatan').value;
        var form_data = new FormData();
        form_data.append('kecamatan', kecamatan);

        $.ajax({
            url: "<?php echo base_url(); ?>registrasiulang/kelurahan",
            dataType: 'JSON',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: 'POST',
            success: function(data) {
                $('#kelurahan').html(data.status);
                $('[name="kelurahan"]').val("<?php echo $siswa->kelurahan; ?>");
            },
            error: function(jqXHR, textStatus, errorThrown) {
                iziToast.error({
                    title: 'Error',
                    message: "Error json " + errorThrown,
                    position: 'topRight'
                });
            }
        });
    }

    function kodeposa() {
        var kelurahan = document.getElementById('kelurahan').value;
        var kecamatan = document.getElementById('kecamatan').value;
        // var kelurahan = 'Hilir';

        // Lakukan request AJAX ke API
        $.ajax({
            url: "https://kodepos.vercel.app/search?q=" + encodeURIComponent(kelurahan)+'+'+ encodeURIComponent(kecamatan), // Gunakan variabel kelurahan
            type: "GET",
            dataType: "JSON",
            success: function(response) {
                // Cek apakah response ditemukan
                if (response.data.length === 0) {
                    alert('Kode pos tidak ditemukan untuk kelurahan tersebut.');
                    return;
                }

                // Ambil kode dari hasil pertama di dalam array 'data'
                let firstResult = response.data[0]; // Ambil hasil pertama
                let zipCode = firstResult.code ? firstResult.code : 'N/A';

                // Tampilkan kode pos ke dalam input dengan id "kodepos"
                document.getElementById('kodepos').value = zipCode;
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

    function hanyaAngka(e, decimal) {
        var key;
        var keychar;
        if (window.event) {
            key = window.event.keyCode;
        } else if (e) {
            key = e.which;
        } else {
            return true;
        }

        keychar = String.fromCharCode(key);
        if ((key == null) || (key == 0) || (key == 8) || (key == 9) || (key == 13) || (key == 27)) {
            return true;
        } else if ((("0123456789").indexOf(keychar) > -1)) {
            return true;
        } else if (decimal && (keychar == ".")) {
            return true;
        } else {
            return false;
        }
    }

    function toggleAlamat() {
        var kewarganegaraan = document.getElementById('kewarganegaraan').value;
        var alamatSection = document.getElementById('alamatSection');

        if (kewarganegaraan === 'Indonesia') {
            alamatSection.style.display = 'block';
        } else {
            alamatSection.style.display = 'none';
        }
    }

    window.onload = function() {
        // Panggil toggleAlamat untuk menampilkan/menyembunyikan bagian alamat berdasarkan kewarganegaraan
        toggleAlamat();

        // Ambil nilai provinsi, kabupaten, kecamatan
        var provinsi = document.getElementById('provinsi').value;
        
        // Jika provinsi tidak default, panggil fungsi berurutan untuk kabupaten, kecamatan, dan kelurahan
        if (provinsi !== '-') {
            pilih_kabupaten(function() {
                pilih_kecamatan(function() {
                    pilih_kelurahan();
                });
            });
        }

        // Pastikan event listener untuk kewarganegaraan diaktifkan
        document.getElementById('kewarganegaraan').addEventListener('change', toggleAlamat);
    };
</script>

</html>