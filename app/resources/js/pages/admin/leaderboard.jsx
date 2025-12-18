import React from 'react';
import { router } from '@inertiajs/react'
import Frame from '@/layouts/admin/frame';
import List from '@/layouts/admin/team-list';
import { __ } from '@/composables/translations';

const setFilter = (e) => {
  router.get(route('leaderboard', e.target.value));
};

export default function TeamList({ groups, teams, filter }) {
  return (
    <List title={__("Leaderboard")} teams={teams} simple>
      <div className="flex w-full items-center">
        <div className="grow text-right mr-2">{__("Filter by group")}</div>
        <div className="flex-none">
          <form>
            <select
              name="group"
              className="border-slate-300 focus:border-purple-300 focus:ring focus:ring-purple-200 focus:ring-opacity-50 rounded-md shadow-sm text-black"
              onChange={setFilter}
              defaultValue={filter || 'all'}
            >
              <option key="all" value="">{__("Show all groups")}</option>
              {groups.map(g => (<option key={g.id} value={g.id}>{g.name}</option>))}
            </select>
          </form>
        </div>
      </div>
    </List>
  )
}
