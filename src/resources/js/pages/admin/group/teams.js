import React from 'react';
import Frame from '@/layouts/admin/frame';
import List from '@/layouts/admin/team-list';

export default function TeamList({ teams, group }) {
  return (
    <List teams={ teams }>{ group }</List>
  )
}
