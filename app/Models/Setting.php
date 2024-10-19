<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'logo',
        'favicon',
        'facebook',
        'twitter',
        'linkedin',
        'instagram',
        'github',
        'phone',
        'email',
        'fax',
        'address',
        'language',
        'country_id',
        'timezone_id',
        'currency_id',
        'copyright_text',
        'google_analytics_id',
        'is_google_analytics',
        'facebook_chat_page_id',
        'is_facebook_chat',
        'recaptcha_site_key',
        'recaptcha_secret_key',
        'is_recaptcha',
        'google_oauth_client_id',
        'google_oauth_secret',
        'is_google_oauth',
        'facebook_oauth_client_id',
        'facebook_oauth_secret',
        'is_facebook_oauth',
        'github_oauth_client_id',
        'github_oauth_secret',
        'is_github_oauth',
        'theme',
        'lang',
        'status',
    ];

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function timezone(): BelongsTo
    {
        return $this->belongsTo(Timezone::class, 'timezone_id');
    }

    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class, 'currency_id');
    }

    protected function theme(): Attribute
    {
        return new Attribute(
            get: fn ($value) => ['default', 'business'][$value],
        );
    }
}
