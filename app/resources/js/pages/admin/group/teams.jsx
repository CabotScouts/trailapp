import React from 'react';
import Frame, { Stripe } from '@/layouts/admin/frame';
import List from '@/layouts/admin/team-list';
import { __ } from '@/composables/translations';

export default function TeamList({ teams, group }) {
  return (
    <List teams={teams}>
      {__("teams_in", { group: <span className="font-bold">{group}</span> })}
    </List>
  )
}
