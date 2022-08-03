import React from 'react';
import { Inertia } from '@inertiajs/inertia'
import Frame from '@/layouts/admin/frame';
import List from '@/layouts/admin/team-list';

const setFilter = (e) => {
  Inertia.get(route('leaderboard', e.target.value));
};

export default function TeamList({ groups, teams, filter }) {
  return (
    <List title="Leaderboard" teams={ teams } simple>
    <div className="flex w-full items-center">
      <div className="grow text-right mr-2">Filter by group</div>
      <div className="flex-none">
        <form>
          <select
          name="group"
          className="border-slate-300 focus:border-purple-300 focus:ring focus:ring-purple-200 focus:ring-opacity-50 rounded-md shadow-sm text-black"
          onChange={ setFilter }
          >
          <option key="all" value="" selected={( filter === false )}>Show all groups</option>
          { groups.map(g => (<option key={ g.id } value={ g.id } selected={( g.id == filter )}>{ g.name }</option>)) }
          </select>
        </form>
      </div>
    </div>
    </List>
  )
}
