@extends('layouts.app')

@section('title', 'Validation des dépôts')

@section('sidebar')
@include('partials.side-bar-admin')
@endsection

@section('content')
<div class="min-h-screen py-4 md:py-8">
    <div class="max-w-6xl mx-auto px-4">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-4 md:mb-6">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-anthracite font-mountains">
                    <i class="fa-solid fa-wallet text-rose-corail mr-2 md:mr-3"></i>
                    Validation des dépôts
                </h1>
                <p class="text-gray-600 mt-1 text-sm md:text-base">Liste des dépôts en attente de validation</p>
            </div>
        </div>
        
        <!-- Mobile view: cards -->
        <div class="md:hidden space-y-3">
            @forelse($depots as $depot)
                <div class="bg-white/90 rounded-xl shadow p-4">
                    <div class="flex justify-between items-start mb-3">
                        <span class="font-bold text-anthracite">#{{ $depot->id_depot }}</span>
                        <span class="text-sm text-gray-600">{{ optional($depot->utilisateur)->nom ?? '—' }}</span>
                    </div>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Montant demandé:</span>
                            <span class="font-bold text-sauge">{{ number_format($depot->montant_demande, 0, ',', ' ') }} Ar</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Commission:</span>
                            <span>{{ $depot->commission_applique }} %</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Montant crédité:</span>
                            <span class="font-medium text-vert-foret">{{ number_format($depot->montant_credit, 0, ',', ' ') }} Ar</span>
                        </div>
                    </div>
                    <div class="flex gap-2 mt-4 pt-3 border-t">
                        <form method="POST" action="{{ route('depot.valider') }}" onsubmit="return confirmValidate(this);" class="flex-1">
                            @csrf
                            <input type="hidden" name="id_depot" value="{{ $depot->id_depot }}">
                            <button type="submit" class="w-full p-2 bg-vert-foret text-white rounded-lg text-sm">
                                <i class="fa-solid fa-check mr-1"></i> Valider
                            </button>
                        </form>
                        <form method="POST" action="{{ route('depot.rejeter') }}" onsubmit="return confirmReject(this);" class="flex-1">
                            @csrf
                            <input type="hidden" name="id_depot" value="{{ $depot->id_depot }}">
                            <button type="submit" class="w-full p-2 bg-rose-corail text-white rounded-lg text-sm">
                                <i class="fa-solid fa-times mr-1"></i> Refuser
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="bg-white/90 rounded-xl shadow p-6 text-center">
                    <i class="fa-solid fa-inbox text-4xl text-gray-300 mb-4"></i>
                    <p class="text-gray-500">Aucun dépôt en attente.</p>
                </div>
            @endforelse
        </div>
        
        <!-- Desktop view: table -->
        <div class="hidden md:block bg-white/90 backdrop-blur-sm rounded-2xl shadow-xl overflow-hidden border border-vert-clair/30">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gradient-to-r from-anthracite to-vert-foret text-white">
                            <th class="px-6 py-4 text-left font-semibold">ID dépôt</th>
                            <th class="px-6 py-4 text-left font-semibold">Utilisateur</th>
                            <th class="px-6 py-4 text-left font-semibold">Montant demandé</th>
                            <th class="px-6 py-4 text-left font-semibold">Commission</th>
                            <th class="px-6 py-4 text-left font-semibold">Montant crédité</th>
                            <th class="px-6 py-4 text-center font-semibold">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($depots as $depot)
                            <tr class="hover:bg-vert-clair/20 transition-colors">
                                <td class="px-6 py-4 text-anthracite font-medium">#{{ $depot->id_depot }}</td>
                                <td class="px-6 py-4 text-anthracite font-medium">{{ optional($depot->utilisateur)->nom ?? '—' }}</span></td>
                                <td class="px-6 py-4"><span class="text-sauge font-bold">{{ number_format($depot->montant_demande, 0, ',', ' ') }} Ar</span></td>
                                <td class="px-6 py-4">{{ $depot->commission_applique }} %</td>
                                <td class="px-6 py-4 text-vert-foret font-medium">{{ number_format($depot->montant_credit, 0, ',', ' ') }} Ar</td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-center gap-2">
                                        <form method="POST" action="{{ route('depot.valider') }}" onsubmit="return confirmValidate(this);">
                                            @csrf
                                            <input type="hidden" name="id_depot" value="{{ $depot->id_depot }}">
                                            <button type="submit" class="p-2 bg-vert-foret text-white rounded-lg hover:bg-vert-foret/90" title="Valider">
                                                <i class="fa-solid fa-check"></i>
                                            </button>
                                        </form>

                                        <form method="POST" action="{{ route('depot.rejeter') }}" onsubmit="return confirmReject(this);">
                                            @csrf
                                            <input type="hidden" name="id_depot" value="{{ $depot->id_depot }}">
                                            <button type="submit" class="p-2 bg-rose-corail text-white rounded-lg hover:bg-rose-corail/90" title="Refuser">
                                                <i class="fa-solid fa-times"></i>
                                            </button>
                                        </form>

                                        <a href="{{ route('admin.parametres.index') }}" class="p-2 border rounded-lg text-gray-600" title="Détails">Détails</a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center">
                                        <i class="fa-solid fa-inbox text-4xl text-gray-300 mb-4"></i>
                                        <p class="text-gray-500 text-lg">Aucun dépôt en attente.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
        <script>
            function confirmValidate(form) {
                var id = form.querySelector('input[name="id_depot"]').value || '';
                return confirm('Confirmer la validation du dépôt #' + id + ' ?');
            }

            function confirmReject(form) {
                var id = form.querySelector('input[name="id_depot"]').value || '';
                return confirm('Confirmer le refus du dépôt #' + id + ' ?');
            }
        </script>
@endsection