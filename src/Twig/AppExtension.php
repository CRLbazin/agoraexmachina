<?php
namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{

	/*********** FILTERS ************/
	public function getFilters()
	{
		return [
			new TwigFilter('slugify', [$this, 'slugify']),
		];
	}

	public function slugify($slug)
	{
		// Remove accents
		$unwanted_array = array(    'Š'=>'S', 'š'=>'s', 'Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
                            'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U',
                            'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss', 'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c',
                            'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o',
                            'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y' );
		$slug = strtr( $slug, $unwanted_array );
		
		// Remove HTML tags
		$slug = preg_replace('/<(.*?)>/u', '', $slug);

		// Remove inner-word punctuation.
		$slug = preg_replace('/[\'"‘’“”]/u', '', $slug);

		// Make it lowercase
		$slug = mb_strtolower($slug, 'UTF-8');
		
		$slug = preg_replace('/[^a-zA-Z0-9\']/', '-', $slug);
		$slug = str_replace("'", '', $slug);
		
		return $slug;
	}
	
	
	/*********** FUNCTIONS ************/
	 public function getFunctions()
    {
        return [
            new TwigFunction('status', [$this, 'status']),
			new TwigFunction('progress', [$this, 'progress']),
        ];
    }

    public function status(\DateTime $date)
    {
		$date = strtotime($date->format('Y-m-d'));
		if($date > time())
		{
			echo '<i class="fas fa-play"></i> <span class="badge badge-primary">In progress</span>';
		}
		else
		{
			echo '<i class="fas fa-stop"></i> <span class="badge badge-secondary">Closed</span>';
		}
    }
	
	public function progress(\DateTime $dateBegin, \DateTime $dateEnd)
	{
		$duration = date_diff($dateBegin, $dateEnd);
		$remaining = date_diff(new \DateTime(), $dateEnd);
		if($remaining->days > 0 && $duration->days > 0)
			echo (($duration->days - $remaining->days) * 100)/($duration->days);
		else
			echo "100";
	}

}