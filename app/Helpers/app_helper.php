<?php

use Config\Services;

if (!function_exists("formatRibuan")) {
    function formatRibuan($angka)
    {
        $angka = number_format($angka, 0, ',', '.');
        return $angka;
    }
}

if (!function_exists("formatSubstr")) {
    function formatSubstr($string, $length)
    {
        $strlen = strlen($string);
        if ($strlen <= intval($length)) {
            return strip_tags($string);
        } else {
            $string = strip_tags(substr($string, 0, $length));
            return $string . '...';
        }
    }
}

if (!function_exists("formatSubstrLink")) {
    function formatSubstrLink($string, $length, $link)
    {
        $string = strip_tags(substr($string, 0, $length));
        return $string . ' [<a href="' . $link . '">' . lang('App.home.readMore') . '</a>]';
    }
}

if (!function_exists("formatFullName")) {
    function formatFullName($firstName = null, $lastName = null)
    {
        $fullName = '';
        if ($firstName != '') {
            $fullName .= $firstName;
        }
        if ($firstName != '' && $lastName != '') {
            $fullName .= ' ';
        }
        if ($lastName != '') {
            $fullName .= $lastName;
        }

        return $fullName;
    }
}

if (!function_exists("formatTanggalNormal")) {
    function formatTanggalNormal($tanggal)
    {
        if ($tanggal != '') {
            return date("d-m-Y", strtotime($tanggal));
        }
    }
}

if (!function_exists("formatTanggalDB")) {
    function formatTanggalDB($tanggal)
    {
        return date("Y-m-d", strtotime($tanggal));
    }
}

if (!function_exists("formatTanggalJamDB")) {
    function formatTanggalJamDB($tanggal)
    {
        return date("Y-m-d H:i:s", strtotime($tanggal));
    }
}

if (!function_exists("format2TanggalIndo")) {
    function format2TanggalIndo($tanggal)
    {
        if ($tanggal == '') {
            return '';
        }
        $tanggal = explode(' to ', $tanggal);
        return formatTanggalIndoShort($tanggal[0]) . (isset($tanggal[1]) ? ' - ' . formatTanggalIndoShort($tanggal[1]) : '');
    }
}

if (!function_exists("formatTanggalIndo")) {
    function formatTanggalIndo($tanggal)
    {
        if ($tanggal == '') {
            return '';
        }
        $tanggal = date('Y-m-d', strtotime($tanggal));
        $locale = service('request')->getLocale();
        if ($locale == 'en') {
            $bulan = array(
                1 => 'January',
                'February',
                'March',
                'April',
                'May',
                'June',
                'July',
                'August',
                'September',
                'October',
                'November',
                'December'
            );
        } else {
            $bulan = array(
                1 => 'Januari',
                'Februari',
                'Maret',
                'April',
                'Mei',
                'Juni',
                'Juli',
                'Agustus',
                'September',
                'Oktober',
                'November',
                'Desember'
            );
        }
        $tgl = explode('-', $tanggal);
        return $tgl[2] . ' ' . $bulan[(int) $tgl[1]] . ' ' . $tgl[0];
    }
}

if (!function_exists("formatTanggalIndoShort")) {
    function formatTanggalIndoShort($tanggal)
    {
        if ($tanggal == '') {
            return '-';
        }
        $tanggal = date('Y-m-d', strtotime($tanggal));
        $locale = service('request')->getLocale();
        if ($locale == 'en') {
            $bulan = array(
                1 => 'Jan',
                'Feb',
                'Mar',
                'Apr',
                'May',
                'Jun',
                'Jul',
                'Aug',
                'Sep',
                'Oct',
                'Nov',
                'Dec'
            );
        } else {
            $bulan = array(
                1 => 'Jan',
                'Feb',
                'Mar',
                'Apr',
                'Mei',
                'Jun',
                'Jul',
                'Agu',
                'Sep',
                'Okt',
                'Nov',
                'Des'
            );
        }
        $tgl = explode('-', $tanggal);
        return $tgl[2] . ' ' . $bulan[(int) $tgl[1]] . ' ' . $tgl[0];
    }
}

if (!function_exists("formatTanggalBulanIndo")) {
    function formatTanggalBulanIndo($tanggal)
    {
        if ($tanggal == '') {
            return '-';
        }
        $tanggal = date('Y-m-d', strtotime($tanggal));
        $locale = service('request')->getLocale();
        if ($locale == 'en') {
            $bulan = array(
                1 => 'January',
                'February',
                'March',
                'April',
                'May',
                'June',
                'July',
                'August',
                'September',
                'October',
                'November',
                'December'
            );
        } else {
            $bulan = array(
                1 => 'Januari',
                'Februari',
                'Maret',
                'April',
                'Mei',
                'Juni',
                'Juli',
                'Agustus',
                'September',
                'Oktober',
                'November',
                'Desember'
            );
        }
        $tgl = explode('-', $tanggal);
        return $bulan[(int) $tgl[1]] . ' ' . $tgl[0];
    }
}

if (!function_exists("formatTanggalIndoJam")) {
    function formatTanggalIndoJam($tanggal)
    {
        if ($tanggal == '') {
            return '-';
        }
        $tanggal = date('Y-m-d H:i:s', strtotime($tanggal));
        $locale = service('request')->getLocale();
        if ($locale == 'en') {
            $bulan = array(
                1 => 'January',
                'February',
                'March',
                'April',
                'May',
                'June',
                'July',
                'August',
                'September',
                'October',
                'November',
                'December'
            );
        } else {
            $bulan = array(
                1 => 'Januari',
                'Februari',
                'Maret',
                'April',
                'Mei',
                'Juni',
                'Juli',
                'Agustus',
                'September',
                'Oktober',
                'November',
                'Desember'
            );
        }
        $waktu = explode(' ', $tanggal);
        $tgl = explode('-', $waktu[0]);
        return $tgl[2] . ' ' . $bulan[(int) $tgl[1]] . ' ' . $tgl[0] . ' ' . $waktu[1];
    }
}

if (!function_exists("formatTanggalHariIndoJam")) {
    function formatTanggalHariIndoJam($tanggal)
    {
        if ($tanggal == '') {
            return '-';
        }
        $tanggal = date('D Y-m-d H:i:s', strtotime($tanggal));
        $locale = service('request')->getLocale();
        $waktu = explode(' ', $tanggal);
        switch ($waktu[0]) {
            case 'Sun':
                $day = "Minggu";
                break;

            case 'Mon':
                $day = "Senin";
                break;

            case 'Tue':
                $day = "Selasa";
                break;

            case 'Wed':
                $day = "Rabu";
                break;

            case 'Thu':
                $day = "Kamis";
                break;

            case 'Fri':
                $day = "Jumat";
                break;

            case 'Sat':
                $day = "Sabtu";
                break;
            default:
                $day = "Tidak di ketahui";
                break;
        }

        if ($locale == 'en') {
            $day = date('l', strtotime($tanggal));
            $bulan = array(
                1 => 'Jan',
                'Feb',
                'Mar',
                'Apr',
                'May',
                'Jun',
                'Jul',
                'Aug',
                'Sep',
                'Oct',
                'Nov',
                'Dec'
            );
        } else {
            $bulan = array(
                1 => 'Jan',
                'Feb',
                'Mar',
                'Apr',
                'Mei',
                'Jun',
                'Jul',
                'Agu',
                'Sep',
                'Okt',
                'Nov',
                'Des'
            );
        }

        $tgl = explode('-', $waktu[1]);
        return $day . ', ' . $tgl[2] . ' ' . $bulan[(int) $tgl[1]] . ' ' . $tgl[0] . ' ' . $waktu[2];
    }
}

if (!function_exists("slugify")) {
    function slugify($text)
    {
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        $text = preg_replace('~[^-\w]+~', '', $text);
        $text = trim($text, '-');
        $text = preg_replace('~-+~', '-', $text);
        $text = strtolower($text);
        $text = url_title($text, '-', true);
        if (empty($text)) {
            return 'n-a';
        }
        return $text;
    }
}

if (!function_exists("checkImageUser")) {
    function checkImageUser($file = null)
    {
        if ($file == '' || !file_exists('uploads/avatar/' . $file)) {
            if (str_contains($file, 'cybercampus')) {
                $file = $file;
            } else {
                if (auth()->user()->gender != '') {
                    $file = base_url('/uploads/avatar/DEFAULT-' . auth()->user()->gender . '.png');
                } else {
                    $file = base_url('/uploads/avatar/DEFAULT-L.png');
                }
            }
            if ($file == '') {
                $file = base_url('/uploads/avatar/default.png');
            }
        } else {
            $file = base_url('/uploads/avatar/' . $file);
        }
        return $file;
    }
}

if (!function_exists("checkImageCover")) {
    function checkImageCover($file = null)
    {
        if ($file == '' || !file_exists('uploads/image_cover/' . $file)) {
            $file = base_url('/uploads/image_cover/default.png');
        } else {
            $file = base_url('/uploads/image_cover/' . $file);
        }
        return $file;
    }
}

if (!function_exists("checkUrlLang")) {
    function checkUrlLang($url)
    {
        $url = strval($url);
        if (preg_match("@^https?://@", $url)) {
            return $url;
        } else {
            return base_url(service('request')->getLocale() . $url);
        }
    }
}

if (!function_exists("getGender")) {
    function getGender($gender)
    {
        if ($gender == 'L') {
            $out = 'Laki-laki';
        } elseif ($gender == 'P') {
            $out = 'Perempuan';
        } else {
            $out = lang('App.dashboard.404data');
        }
        return $out;
    }
}

if (!function_exists("selisihTanggal")) {
    function selisihTanggal($tanggal)
    {
        $tanggal = strtotime($tanggal);
        $selisih = time() - $tanggal;
        $hari = floor($selisih / (60 * 60 * 24));
        $jam = floor(($selisih % (60 * 60 * 24)) / (60 * 60));
        $menit = floor((($selisih % (60 * 60 * 24)) % (60 * 60)) / 60);
        $detik = floor((($selisih % (60 * 60 * 24)) % (60 * 60)) % 60);
        $locale = service('request')->getLocale();
        if ($locale == 'en') {
            if ($hari > 0) {
                return $hari . ' d ' . $jam . ' h ' . $menit . ' m';
            } elseif ($jam > 0) {
                return $jam . ' h ' . $menit . ' m';
            } elseif ($menit > 0) {
                return $menit . ' minute';
            } else {
                return 'just now';
            }
        } else {
            if ($hari > 0) {
                return $hari . ' h ' . $jam . ' j ' . $menit . ' m';
            } elseif ($jam > 0) {
                return $jam . ' j ' . $menit . ' m';
            } elseif ($menit > 0) {
                return $menit . ' menit';
            } else {
                return 'baru saja';
            }
        }
    }
}

if (!function_exists("sisaTanggal")) {
    function sisaTanggal($tanggal)
    {
        $awal = date_create();
        $akhir = date_create(formatTanggalDB($tanggal));
        $diff = date_diff($awal, $akhir);
        $tahun = $diff->y;
        $bulan = $diff->m;
        $hari = $diff->d;
        $locale = service('request')->getLocale();
        if ($locale == 'en') {
            if ($tahun > 0) {
                return '<span class="badge bg-info">' . $tahun . '<small>y</small> ' . $bulan . '<small>m</small> ' . $hari . '<small>d</small>' . '</span>';
            } elseif ($bulan > 0) {
                if ($bulan > 6) {
                    return '<span class="badge bg-info">' . $bulan . '<small>m</small> ' . $hari . '<small>d</small>' . '</span>';
                } else {
                    return '<span class="badge bg-warning">' . $bulan . '<small>m</small> ' . $hari . '<small>d</small>' . '</span>';
                }
            } elseif ($hari > 0) {
                return '<span class="badge bg-warning">' . $hari . '<small>d</small>' . '</span>';
            } else {
                return '';
            }
        } else {
            if ($tahun > 0) {
                return '<span class="badge bg-info">' . $tahun . '<small>t</small> ' . $bulan . '<small>b</small> ' . $hari . '<small>h</small>' . '</span>';
            } elseif ($bulan > 0) {
                if ($bulan > 6) {
                    return '<span class="badge bg-info">' . $bulan . ' <small>b</small> ' . $hari . ' <small>h</small>' . '</span>';
                } else {
                    return '<span class="badge bg-warning">' . $bulan . ' <small>b</small> ' . $hari . ' <small>h</small>' . '</span>';
                }
            } elseif ($hari > 0) {
                return '<span class="badge bg-warning">' . $hari . ' <small>h</small>' . '</span>';
            } else {
                return '';
            }
        }
    }
}

if (!function_exists("getFileSize")) {
    function getFileSize($folder, $type = 'mb')
    {
        $file = new \CodeIgniter\Files\File(FCPATH . $folder);
        $size = $file->getSizeByUnit(strtolower($type));
        $size = round($size, 2);
        return $size . ' ' . strtoupper($type);
    }
}

if (!function_exists("checkData")) {
    function checkData($data)
    {
        if (is_null($data) || $data == null || $data == '') {
            return lang('App.dashboard.404data');
        } else {
            return $data;
        }
    }
}

if (!function_exists("checkData2")) {
    function checkData2($data)
    {
        if (is_null($data) || $data == null || $data == '') {
            return '-';
        } else {
            return $data;
        }
    }
}

if (!function_exists("urlMenu")) {
    function urlMenu($route = null, $param = null)
    {
        if ($route != '') {
            $locale = service('request')->getLocale();
            if ($param != '') {
                return base_url($locale . str_replace('(:any)', $param, $route));
            } else {
                return base_url($locale . $route);
            }
        } else {
            return '#';
        }
    }
}

if (!function_exists("urlMenuDashboard")) {
    function urlMenuDashboard($route = null, $param = null)
    {
        if ($route != '') {
            $locale = service('request')->getLocale();
            if ($param != '') {
                $url = base_url($locale . str_replace('(:any)', $param, $route));
            } else {
                $url = base_url($locale . $route);
            }
            return str_replace(base_url(), '/', $url);
        } else {
            return '#';
        }
    }
}

if (!function_exists("checkDataLang")) {
    function checkDataLang($valueID, $valueEN = null)
    {
        $locale = service('request')->getLocale();
        if ($locale == 'en') {
            if ($valueEN != '') {
                return $valueEN;
            }
        }
        return $valueID;
    }
}

if (!function_exists("checkPermission")) {
    function checkPermission($filter, $value = null)
    {
        if ($filter == 'session') {
            return auth()->loggedIn();
        } else if ($filter == 'group') {
            return auth()->user()->inGroup($value);
        } else if ($filter == 'permission') {
            return auth()->user()->can($value);
        } else {
            return false;
        }
    }
}

if (!function_exists("cleanLink")) {
    function cleanLink($link)
    {
        return str_replace(base_url(), '', '/' . $link);
    }
}

if (!function_exists("getRouteName")) {
    function getRouteName()
    {
        if (isset(\CodeIgniter\Config\Services::router()->getMatchedRouteOptions()['as'])) {
            return \CodeIgniter\Config\Services::router()->getMatchedRouteOptions()['as'];
        } else {
            return 'dashboard';
        }
    }
}

if (!function_exists("checkStatusUser")) {
    function checkStatusUser($status)
    {
        if ($status == '0') {
            $out = [
                'bg' => 'danger',
                'label' => lang('App.dashboard.inactive'),
            ];
        } else if ($status == '1') {
            $out = [
                'bg' => 'primary',
                'label' => lang('App.dashboard.active'),
            ];
        } else {
            $out = [
                'bg' => 'danger',
                'label' => lang('App.dashboard.inactive'),
            ];
        }
        return '<span class="badge bg-' . $out['bg'] . '-subtle text-' . $out['bg'] . ' fs-12">' . $out['label'] . '</span>';
    }
}

if (!function_exists("setRemixIcon")) {
    function setRemixIcon($icon)
    {
        if ($icon != '') {
            return '<i class="' . $icon . ' fs-14 align-middle"></i>';
        } else {
            return '<i class="ri-file-text-line fs-14 align-middle"></i>';
        }
    }
}
