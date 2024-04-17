<?php

namespace JoeDixon\Translation\Http\Controllers;

use App\Models\Label;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Gate;
use JoeDixon\Translation\Drivers\Translation;
use JoeDixon\Translation\Http\Requests\LanguageDestroyRequest;
use JoeDixon\Translation\Http\Requests\LanguageRequest;
use Symfony\Component\HttpFoundation\Response;

class LanguageController extends Controller
{
    private $translation;

    public function __construct(Translation $translation)
    {
        $this->translation = $translation;
    }

    public function index(Request $request)
    {
        $languages = $this->translation->allLanguages();

        return inertia('Panel/Languages/Index', compact('languages'));
    }

    public function create()
    {
        return inertia('Panel/Languages/Create');
    }

    public function store(LanguageRequest $request)
    {
        $this->translation->addLanguage($request->locale, $request->name);

        return redirect()
            ->route('languages.index')
            ->with('success', __('translation::translation.language_added'));
    }

    public function destroy(LanguageDestroyRequest $request)
    {

        $this->translation->deleteDirectory($request->validated()['language']);

        return redirect()->back();
    }
}
